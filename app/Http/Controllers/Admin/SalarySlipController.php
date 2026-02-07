<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SalarySlip;
use App\Models\SalaryDeduction;
use App\Models\SalaryAdvance;
use App\Models\Staff;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class SalarySlipController extends Controller
{
    /**
     * Display listing of salary slips.
     */
    public function index(Request $request)
    {
        $month = $request->get('month', date('n'));
        $year = $request->get('year', date('Y'));
        $status = $request->get('status');

        $query = SalarySlip::where('school_id', session('school_id'))
            ->with('staff')
            ->when($month, fn($q) => $q->where('month', $month))
            ->when($year, fn($q) => $q->where('year', $year))
            ->when($status, fn($q) => $q->where('status', $status))
            ->orderBy('created_at', 'desc');

        $salarySlips = $query->paginate(20);

        $stats = [
            'total' => SalarySlip::where('school_id', session('school_id'))
                ->where('month', $month)->where('year', $year)->count(),
            'paid' => SalarySlip::where('school_id', session('school_id'))
                ->where('month', $month)->where('year', $year)->where('status', 'paid')->count(),
            'pending' => SalarySlip::where('school_id', session('school_id'))
                ->where('month', $month)->where('year', $year)->whereIn('status', ['draft', 'generated'])->count(),
            'total_amount' => SalarySlip::where('school_id', session('school_id'))
                ->where('month', $month)->where('year', $year)->where('status', 'paid')->sum('net_salary'),
        ];

        return view('admin.salary-slips.index', compact('salarySlips', 'month', 'year', 'status', 'stats'));
    }

    /**
     * Show form for creating salary slips.
     */
    public function create(Request $request)
    {
        $month = $request->get('month', date('n'));
        $year = $request->get('year', date('Y'));

        // Get staff who don't have salary slips for this month
        $existingStaffIds = SalarySlip::where('school_id', session('school_id'))
            ->where('month', $month)
            ->where('year', $year)
            ->pluck('staff_id');

        $staff = Staff::where('school_id', session('school_id'))
            ->where('status', 'active')
            ->whereNotIn('id', $existingStaffIds)
            ->orderBy('name')
            ->get();

        return view('admin.salary-slips.create', compact('staff', 'month', 'year'));
    }

    /**
     * Generate salary slips for selected staff.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'month' => 'required|integer|min:1|max:12',
            'year' => 'required|integer|min:2020|max:2100',
            'staff_ids' => 'required|array',
            'staff_ids.*' => 'exists:staff,id',
            'allowances' => 'nullable|array',
            'allowances.*' => 'nullable|numeric|min:0',
        ]);

        $schoolId = session('school_id');
        $generated = 0;

        foreach ($validated['staff_ids'] as $staffId) {
            $staff = Staff::find($staffId);
            if (!$staff)
                continue;

            // Check if slip already exists
            $exists = SalarySlip::where('school_id', $schoolId)
                ->where('staff_id', $staffId)
                ->where('month', $validated['month'])
                ->where('year', $validated['year'])
                ->exists();

            if ($exists)
                continue;

            $basicSalary = $staff->salary ?? 0;
            $allowances = $validated['allowances'][$staffId] ?? 0;
            $grossSalary = $basicSalary + $allowances;

            // Calculate deductions from pending advances
            $pendingAdvances = SalaryAdvance::where('staff_id', $staffId)
                ->where('status', 'approved')
                ->whereColumn('recovered_amount', '<', 'amount')
                ->get();

            $totalDeductions = 0;
            $deductionItems = [];

            foreach ($pendingAdvances as $advance) {
                $pendingBalance = $advance->amount - $advance->recovered_amount;
                $deductionAmount = min($pendingBalance, $grossSalary * 0.2); // Max 20% of salary

                if ($deductionAmount > 0) {
                    $deductionItems[] = [
                        'type' => 'advance_recovery',
                        'description' => 'Advance Recovery - ' . $advance->advance_date->format('d M Y'),
                        'amount' => $deductionAmount,
                        'salary_advance_id' => $advance->id,
                    ];
                    $totalDeductions += $deductionAmount;
                }
            }

            $netSalary = $grossSalary - $totalDeductions;

            $salarySlip = SalarySlip::create([
                'school_id' => $schoolId,
                'staff_id' => $staffId,
                'slip_no' => SalarySlip::generateSlipNo($schoolId),
                'month' => $validated['month'],
                'year' => $validated['year'],
                'basic_salary' => $basicSalary,
                'allowances' => $allowances,
                'gross_salary' => $grossSalary,
                'total_deductions' => $totalDeductions,
                'net_salary' => $netSalary,
                'status' => 'generated',
            ]);

            // Create deduction records
            foreach ($deductionItems as $item) {
                SalaryDeduction::create([
                    'school_id' => $schoolId,
                    'salary_slip_id' => $salarySlip->id,
                    'salary_advance_id' => $item['salary_advance_id'] ?? null,
                    'type' => $item['type'],
                    'description' => $item['description'],
                    'amount' => $item['amount'],
                ]);
            }

            $generated++;
        }

        return redirect()->route('admin.salary-slips.index', [
            'month' => $validated['month'],
            'year' => $validated['year']
        ])->with('success', "{$generated} salary slip(s) generated successfully.");
    }

    /**
     * Show salary slip details.
     */
    public function show(SalarySlip $salarySlip)
    {
        $salarySlip->load(['staff', 'deductions']);
        return view('admin.salary-slips.show', compact('salarySlip'));
    }

    /**
     * Mark salary slip as paid.
     */
    public function markPaid(Request $request, SalarySlip $salarySlip)
    {
        $validated = $request->validate([
            'payment_date' => 'required|date',
            'payment_mode' => 'required|in:cash,bank,cheque,upi',
            'payment_reference' => 'nullable|string|max:100',
        ]);

        $salarySlip->update([
            'status' => 'paid',
            'payment_date' => $validated['payment_date'],
            'payment_mode' => $validated['payment_mode'],
            'payment_reference' => $validated['payment_reference'],
        ]);

        // Update advance recovery status
        foreach ($salarySlip->deductions as $deduction) {
            if ($deduction->salary_advance_id) {
                $advance = $deduction->advance;
                if ($advance) {
                    $advance->recovered_amount += $deduction->amount;
                    if ($advance->recovered_amount >= $advance->amount) {
                        $advance->status = 'recovered';
                    }
                    $advance->save();
                }
            }
        }

        return redirect()->route('admin.salary-slips.show', $salarySlip)
            ->with('success', 'Salary slip marked as paid.');
    }

    /**
     * Generate PDF for salary slip.
     */
    public function downloadPdf(SalarySlip $salarySlip)
    {
        $salarySlip->load(['staff', 'deductions']);

        $pdf = Pdf::loadView('admin.salary-slips.pdf', compact('salarySlip'));

        return $pdf->download("salary_slip_{$salarySlip->slip_no}.pdf");
    }

    /**
     * Delete salary slip (only draft/generated).
     */
    public function destroy(SalarySlip $salarySlip)
    {
        if ($salarySlip->status === 'paid') {
            return back()->with('error', 'Cannot delete a paid salary slip.');
        }

        $salarySlip->deductions()->delete();
        $salarySlip->delete();

        return redirect()->route('admin.salary-slips.index')
            ->with('success', 'Salary slip deleted successfully.');
    }
}
