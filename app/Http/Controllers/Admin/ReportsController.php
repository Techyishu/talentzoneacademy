<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AcademicSession;
use App\Models\FeeHead;
use App\Models\FeeReceipt;
use App\Models\SchoolClass;
use App\Models\Section;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\FeeCollectionExport;
use App\Exports\StudentsByClassExport;

class ReportsController extends Controller
{
    /**
     * Display the fee collection summary report.
     */
    public function feeCollection(Request $request)
    {
        $fromDate = $request->get('from_date', now()->startOfMonth()->toDateString());
        $toDate = $request->get('to_date', now()->toDateString());
        $paymentMode = $request->get('payment_mode');

        // Get collection summary by date
        $dailyCollection = FeeReceipt::where('status', 'paid')
            ->whereBetween('receipt_date', [$fromDate, $toDate])
            ->when($paymentMode, fn($q) => $q->where('payment_mode', $paymentMode))
            ->selectRaw('DATE(receipt_date) as date, payment_mode, SUM(amount) as total, COUNT(*) as count')
            ->groupBy('date', 'payment_mode')
            ->orderBy('date', 'desc')
            ->get();

        // Get totals by payment mode
        $totalsByMode = FeeReceipt::where('status', 'paid')
            ->whereBetween('receipt_date', [$fromDate, $toDate])
            ->when($paymentMode, fn($q) => $q->where('payment_mode', $paymentMode))
            ->selectRaw('payment_mode, SUM(amount) as total, COUNT(*) as count')
            ->groupBy('payment_mode')
            ->get();

        // Get grand total
        $grandTotal = FeeReceipt::where('status', 'paid')
            ->whereBetween('receipt_date', [$fromDate, $toDate])
            ->when($paymentMode, fn($q) => $q->where('payment_mode', $paymentMode))
            ->sum('amount');

        $totalReceipts = FeeReceipt::where('status', 'paid')
            ->whereBetween('receipt_date', [$fromDate, $toDate])
            ->when($paymentMode, fn($q) => $q->where('payment_mode', $paymentMode))
            ->count();

        // Get collection by fee head (if itemized receipts exist)
        $collectionByFeeHead = DB::table('fee_receipt_items')
            ->join('fee_receipts', 'fee_receipt_items.fee_receipt_id', '=', 'fee_receipts.id')
            ->join('fee_heads', 'fee_receipt_items.fee_head_id', '=', 'fee_heads.id')
            ->where('fee_receipts.status', 'paid')
            ->where('fee_receipts.school_id', session('active_school_id'))
            ->whereBetween('fee_receipts.receipt_date', [$fromDate, $toDate])
            ->selectRaw('fee_heads.name as fee_head, SUM(fee_receipt_items.amount) as total')
            ->groupBy('fee_heads.id', 'fee_heads.name')
            ->orderByDesc('total')
            ->get();

        // Recent receipts
        $recentReceipts = FeeReceipt::with('student')
            ->where('status', 'paid')
            ->whereBetween('receipt_date', [$fromDate, $toDate])
            ->when($paymentMode, fn($q) => $q->where('payment_mode', $paymentMode))
            ->orderBy('receipt_date', 'desc')
            ->orderBy('id', 'desc')
            ->limit(20)
            ->get();

        return view('admin.reports.fee-collection', compact(
            'fromDate',
            'toDate',
            'paymentMode',
            'dailyCollection',
            'totalsByMode',
            'grandTotal',
            'totalReceipts',
            'collectionByFeeHead',
            'recentReceipts'
        ));
    }

    /**
     * Export fee collection report to Excel.
     */
    public function feeCollectionExport(Request $request)
    {
        $fromDate = $request->get('from_date', now()->startOfMonth()->toDateString());
        $toDate = $request->get('to_date', now()->toDateString());
        $paymentMode = $request->get('payment_mode');

        return Excel::download(
            new FeeCollectionExport($fromDate, $toDate, $paymentMode),
            'fee-collection-' . $fromDate . '-to-' . $toDate . '.xlsx'
        );
    }

    /**
     * Display students count by class/section report.
     */
    public function studentsByClass(Request $request)
    {
        $status = $request->get('status', 'active');

        // Get students count by class and section
        $classSummary = SchoolClass::withCount(['students' => function ($query) use ($status) {
                if ($status !== 'all') {
                    $query->where('status', $status);
                }
            }])
            ->with(['sections' => function ($query) use ($status) {
                $query->withCount(['students' => function ($q) use ($status) {
                    if ($status !== 'all') {
                        $q->where('status', $status);
                    }
                }]);
            }])
            ->orderBy('display_order')
            ->orderBy('name')
            ->get();

        // Get gender breakdown
        $genderBreakdown = Student::when($status !== 'all', fn($q) => $q->where('status', $status))
            ->selectRaw('gender, COUNT(*) as count')
            ->groupBy('gender')
            ->get()
            ->pluck('count', 'gender');

        // Get total counts
        $totalStudents = Student::when($status !== 'all', fn($q) => $q->where('status', $status))->count();
        $totalClasses = SchoolClass::count();

        return view('admin.reports.students-by-class', compact(
            'classSummary',
            'genderBreakdown',
            'totalStudents',
            'totalClasses',
            'status'
        ));
    }

    /**
     * Export students by class report to Excel.
     */
    public function studentsByClassExport(Request $request)
    {
        $status = $request->get('status', 'active');

        return Excel::download(
            new StudentsByClassExport($status),
            'students-by-class-' . now()->format('Y-m-d') . '.xlsx'
        );
    }
}
