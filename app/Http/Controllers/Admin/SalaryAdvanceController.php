<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SalaryAdvance;
use App\Models\Staff;
use Illuminate\Http\Request;

class SalaryAdvanceController extends Controller
{
    /**
     * Display listing of advances.
     */
    public function index(Request $request)
    {
        $status = $request->get('status');
        $staffId = $request->get('staff_id');

        $query = SalaryAdvance::where('school_id', session('active_school_id'))
            ->with('staff')
            ->when($status, fn($q) => $q->where('status', $status))
            ->when($staffId, fn($q) => $q->where('staff_id', $staffId))
            ->orderBy('advance_date', 'desc');

        $advances = $query->paginate(20);

        $staff = Staff::where('school_id', session('active_school_id'))
            ->where('status', 'active')
            ->orderBy('name')
            ->get();

        $stats = [
            'total' => SalaryAdvance::where('school_id', session('active_school_id'))->sum('amount'),
            'recovered' => SalaryAdvance::where('school_id', session('active_school_id'))->sum('recovered_amount'),
            'pending' => SalaryAdvance::where('school_id', session('active_school_id'))
                ->whereIn('status', ['pending', 'approved'])
                ->selectRaw('SUM(amount - recovered_amount) as balance')
                ->value('balance') ?? 0,
        ];

        return view('admin.salary-advances.index', compact('advances', 'staff', 'status', 'staffId', 'stats'));
    }

    /**
     * Show form for creating advance.
     */
    public function create()
    {
        $staff = Staff::where('school_id', session('active_school_id'))
            ->where('status', 'active')
            ->orderBy('name')
            ->get();

        return view('admin.salary-advances.create', compact('staff'));
    }

    /**
     * Store new advance.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'staff_id' => 'required|exists:staff,id',
            'amount' => 'required|numeric|min:1',
            'advance_date' => 'required|date',
            'reason' => 'nullable|string|max:255',
            'notes' => 'nullable|string|max:500',
        ]);

        SalaryAdvance::create([
            'school_id' => session('active_school_id'),
            'staff_id' => $validated['staff_id'],
            'amount' => $validated['amount'],
            'advance_date' => $validated['advance_date'],
            'reason' => $validated['reason'],
            'notes' => $validated['notes'],
            'status' => 'pending',
        ]);

        return redirect()->route('admin.salary-advances.index')
            ->with('success', 'Salary advance recorded successfully.');
    }

    /**
     * Show advance details.
     */
    public function show(SalaryAdvance $salaryAdvance)
    {
        $salaryAdvance->load(['staff', 'deductions.salarySlip']);
        return view('admin.salary-advances.show', compact('salaryAdvance'));
    }

    /**
     * Approve advance.
     */
    public function approve(SalaryAdvance $salaryAdvance)
    {
        if ($salaryAdvance->status !== 'pending') {
            return back()->with('error', 'Only pending advances can be approved.');
        }

        $salaryAdvance->update(['status' => 'approved']);

        return back()->with('success', 'Advance approved successfully.');
    }

    /**
     * Reject advance.
     */
    public function reject(SalaryAdvance $salaryAdvance)
    {
        if ($salaryAdvance->status !== 'pending') {
            return back()->with('error', 'Only pending advances can be rejected.');
        }

        $salaryAdvance->update(['status' => 'rejected']);

        return back()->with('success', 'Advance rejected.');
    }

    /**
     * Delete advance.
     */
    public function destroy(SalaryAdvance $salaryAdvance)
    {
        if ($salaryAdvance->recovered_amount > 0) {
            return back()->with('error', 'Cannot delete advance with recovery records.');
        }

        $salaryAdvance->delete();

        return redirect()->route('admin.salary-advances.index')
            ->with('success', 'Advance deleted successfully.');
    }
}
