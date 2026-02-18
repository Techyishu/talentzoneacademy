<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AcademicSession;
use App\Models\FeeReceipt;
use App\Models\FeeReceiptItem;
use App\Models\Student;
use App\Models\User;
use App\Http\Requests\StoreFeeReceiptRequest;
use App\Services\FamilyFeeService;
use App\Services\FeeBalanceService;
use App\Services\ReceiptPdfService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FeeReceiptController extends Controller
{
    protected $pdfService;
    protected $balanceService;
    protected $familyFeeService;

    public function __construct(
        ReceiptPdfService $pdfService,
        FeeBalanceService $balanceService,
        FamilyFeeService $familyFeeService
    ) {
        $this->pdfService = $pdfService;
        $this->balanceService = $balanceService;
        $this->familyFeeService = $familyFeeService;
    }

    /**
     * Display a listing of fee receipts with filters.
     */
    public function index(Request $request)
    {
        $query = FeeReceipt::with(['student']);

        // Search by receipt number or student name
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('receipt_no', 'like', "%{$search}%")
                    ->orWhereHas('student', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    });
            });
        }

        // Filter by payment mode
        if ($request->filled('payment_mode')) {
            $query->where('payment_mode', $request->payment_mode);
        }

        // Filter by cancelled status
        if ($request->filled('status')) {
            $query->where('cancelled', $request->status === 'cancelled');
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('payment_date', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('payment_date', '<=', $request->date_to);
        }

        $receipts = $query->latest('payment_date')->paginate(15);

        // Get totals for display
        $totalAmount = $query->where('cancelled', false)->sum('amount');
        $totalReceipts = $query->where('cancelled', false)->count();

        return view('admin.fee-receipts.index', compact('receipts', 'totalAmount', 'totalReceipts'));
    }

    /**
     * Show the form for creating a new fee receipt.
     */
    public function create(Request $request)
    {
        $students = Student::where('status', 'active')
            ->with(['schoolClass', 'schoolSection'])
            ->orderBy('name')
            ->get();

        // Get parents for family payment option
        $parents = User::where('role', 'parent')
            ->where('school_id', session('active_school_id'))
            ->whereHas('children')
            ->orderBy('name')
            ->get();

        $sessions = AcademicSession::orderBy('start_date', 'desc')->get();
        $activeSession = AcademicSession::where('is_current', true)->first();

        // If a student is pre-selected, get their balance summary
        $balanceSummary = null;
        $selectedStudent = null;
        if ($request->filled('student_id')) {
            $selectedStudent = Student::with(['schoolClass', 'schoolSection'])->find($request->student_id);
            if ($selectedStudent && $activeSession) {
                $balanceSummary = $this->balanceService->getBalanceSummary($selectedStudent, $activeSession->id);
            }
        }

        return view('admin.fee-receipts.create', compact(
            'students',
            'parents',
            'sessions',
            'activeSession',
            'balanceSummary',
            'selectedStudent'
        ));
    }

    /**
     * Store a newly created fee receipt in storage.
     */
    public function store(Request $request)
    {
        $paymentType = $request->input('payment_type', 'student');

        if ($paymentType === 'family') {
            return $this->storeFamilyPayment($request);
        }

        // Standard student payment
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'academic_session_id' => 'nullable|exists:academic_sessions,id',
            'payment_mode' => 'required|in:cash,cheque,online,upi,card',
            'payment_date' => 'required|date',
            'fee_month' => 'nullable|string|max:20',
            'remarks' => 'nullable|string',
            'fee_items' => 'required|array|min:1',
            'fee_items.*.description' => 'required|string|max:255',
            'fee_items.*.amount' => 'required|numeric|min:0.01',
        ]);

        DB::transaction(function () use ($validated, &$receipt) {
            // Calculate total amount
            $totalAmount = collect($validated['fee_items'])->sum('amount');

            // Create receipt
            $receipt = FeeReceipt::create([
                'school_id' => session('active_school_id'),
                'student_id' => $validated['student_id'],
                'receipt_no' => $this->generateReceiptNumber(),
                'transaction_type' => 'payment',
                'payment_type' => 'student',
                'academic_session_id' => $validated['academic_session_id'] ?? session('active_session_id'),
                'amount' => $totalAmount,
                'payment_mode' => $validated['payment_mode'],
                'payment_date' => $validated['payment_date'],
                'fee_month' => $validated['fee_month'],
                'remarks' => $validated['remarks'],
            ]);

            // Create receipt items with description
            foreach ($validated['fee_items'] as $item) {
                FeeReceiptItem::create([
                    'fee_receipt_id' => $receipt->id,
                    'description' => $item['description'],
                    'amount' => $item['amount'],
                ]);
            }

            // Update balances
            if ($receipt->academic_session_id) {
                $this->balanceService->recordPayment($receipt);
            }
        });

        return redirect()->route('admin.fee-receipts.show', $receipt)
            ->with('success', 'Fee receipt created successfully!');
    }

    /**
     * Store a family payment receipt.
     */
    protected function storeFamilyPayment(Request $request)
    {
        $validated = $request->validate([
            'parent_user_id' => 'required|exists:users,id',
            'academic_session_id' => 'nullable|exists:academic_sessions,id',
            'amount' => 'required|numeric|min:0.01',
            'payment_mode' => 'required|in:cash,cheque,online,upi,card',
            'payment_date' => 'required|date',
            'fee_month' => 'nullable|string|max:20',
            'remarks' => 'nullable|string',
        ]);

        DB::transaction(function () use ($validated, &$receipt) {
            $parent = User::findOrFail($validated['parent_user_id']);
            $sessionId = $validated['academic_session_id'] ?? session('active_session_id');

            // Create family receipt
            $receipt = FeeReceipt::create([
                'school_id' => session('active_school_id'),
                'student_id' => null, // Family payment doesn't have a specific student
                'parent_user_id' => $parent->id,
                'receipt_no' => $this->generateReceiptNumber(),
                'transaction_type' => 'payment',
                'payment_type' => 'family',
                'academic_session_id' => $sessionId,
                'amount' => $validated['amount'],
                'payment_mode' => $validated['payment_mode'],
                'payment_date' => $validated['payment_date'],
                'fee_month' => $validated['fee_month'],
                'remarks' => $validated['remarks'],
            ]);

            // Record family payment and distribute across children
            $this->familyFeeService->recordFamilyPayment($receipt);
        });

        return redirect()->route('admin.fee-receipts.show', $receipt)
            ->with('success', 'Family payment recorded successfully and distributed across students!');
    }

    /**
     * Load family balance summary for AJAX requests.
     */
    public function loadFamilyBalance(User $parent)
    {
        $activeSession = AcademicSession::where('school_id', session('active_school_id'))
            ->where('is_current', true)
            ->first();

        if (!$activeSession) {
            return response()->json(['error' => 'No active academic session found'], 404);
        }

        $familyBalance = $this->familyFeeService->calculateFamilyBalance($parent, $activeSession->id);

        return response()->json($familyBalance);
    }

    /**
     * Display the specified fee receipt.
     */
    public function show(FeeReceipt $feeReceipt)
    {
        $feeReceipt->load(['student.schoolClass', 'student.schoolSection', 'school', 'items.feeHead', 'academicSession']);
        return view('admin.fee-receipts.show', compact('feeReceipt'));
    }

    /**
     * Generate PDF for the specified fee receipt.
     */
    public function pdf(FeeReceipt $feeReceipt)
    {
        return $this->pdfService->stream($feeReceipt);
    }

    /**
     * Download PDF for the specified fee receipt.
     */
    public function download(FeeReceipt $feeReceipt)
    {
        return $this->pdfService->download($feeReceipt);
    }

    /**
     * Cancel a fee receipt.
     */
    public function cancel(FeeReceipt $feeReceipt)
    {
        if ($feeReceipt->cancelled) {
            return back()->with('error', 'This receipt is already cancelled.');
        }

        DB::transaction(function () use ($feeReceipt) {
            // Reverse balance updates
            if ($feeReceipt->academic_session_id) {
                $feeReceipt->load('items');
                $this->balanceService->reversePayment($feeReceipt);
            }

            // Mark as cancelled
            $feeReceipt->update([
                'cancelled' => true,
                'cancelled_at' => now(),
                'cancelled_by' => auth()->id(),
            ]);
        });

        return redirect()->route('admin.fee-receipts.index')
            ->with('success', 'Fee receipt cancelled successfully.');
    }

    /**
     * Export receipts to CSV.
     */
    public function export(Request $request)
    {
        $query = FeeReceipt::with(['student']);

        // Apply same filters as index
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('receipt_no', 'like', "%{$search}%")
                    ->orWhereHas('student', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    });
            });
        }

        if ($request->filled('payment_mode')) {
            $query->where('payment_mode', $request->payment_mode);
        }

        if ($request->filled('status')) {
            $query->where('cancelled', $request->status === 'cancelled');
        }

        $receipts = $query->orderBy('payment_date', 'desc')->get();

        $filename = 'fee_receipts_' . date('Y-m-d') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () use ($receipts) {
            $file = fopen('php://output', 'w');

            // Add CSV headers
            fputcsv($file, [
                'Receipt No',
                'Student Name',
                'Admission No',
                'Amount',
                'Payment Mode',
                'Payment Date',
                'Fee Month',
                'Remarks',
                'Status'
            ]);

            // Add data rows
            foreach ($receipts as $receipt) {
                fputcsv($file, [
                    $receipt->receipt_no,
                    $receipt->student->name,
                    $receipt->student->admission_no,
                    $receipt->amount,
                    $receipt->payment_mode,
                    $receipt->payment_date,
                    $receipt->fee_month,
                    $receipt->remarks,
                    $receipt->cancelled ? 'Cancelled' : 'Active'
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Generate unique receipt number for the school.
     */
    private function generateReceiptNumber()
    {
        return DB::transaction(function () {
            $schoolId = session('active_school_id');
            $school = \App\Models\School::find($schoolId);
            $prefix = $school->receipt_prefix ?? 'RCP';

            // Format: PREFIX-YYYYMM-XXXX (e.g., RCP-202602-0001)
            $yearMonth = date('Ym');

            // Get last receipt number for this school and month
            $lastReceipt = FeeReceipt::where('school_id', $schoolId)
                ->where('receipt_no', 'like', "{$prefix}-{$yearMonth}-%")
                ->lockForUpdate()
                ->orderBy('id', 'desc')
                ->first();

            if ($lastReceipt) {
                // Extract sequence number and increment
                $parts = explode('-', $lastReceipt->receipt_no);
                $sequence = intval(end($parts)) + 1;
            } else {
                $sequence = 1;
            }

            return sprintf('%s-%s-%04d', $prefix, $yearMonth, $sequence);
        });
    }
}
