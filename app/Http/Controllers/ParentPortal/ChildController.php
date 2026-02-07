<?php

namespace App\Http\Controllers\ParentPortal;

use App\Http\Controllers\Controller;
use App\Models\FeeReceipt;
use App\Models\Student;
use App\Services\ReceiptPdfService;
use Illuminate\Http\Request;

class ChildController extends Controller
{
    /**
     * Display details for a specific child.
     */
    public function show(Request $request, Student $student)
    {
        $user = $request->user();

        // Verify this child belongs to the parent
        if (!$user->children()->where('students.id', $student->id)->exists()) {
            abort(403, 'Unauthorized access to this student.');
        }

        $student->load(['schoolClass', 'schoolSection']);

        // Get fee receipts
        $receipts = FeeReceipt::where('student_id', $student->id)
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        $totalPaid = FeeReceipt::where('student_id', $student->id)->sum('amount');

        // Get attendance for current month
        $month = $request->get('month', now()->month);
        $year = $request->get('year', now()->year);

        $attendances = $student->attendances()
            ->whereYear('date', $year)
            ->whereMonth('date', $month)
            ->orderBy('date', 'desc')
            ->get();

        $attendanceStats = [
            'present' => $attendances->where('status', 'present')->count(),
            'absent' => $attendances->where('status', 'absent')->count(),
            'late' => $attendances->where('status', 'late')->count(),
            'leave' => $attendances->where('status', 'leave')->count(),
            'total' => $attendances->count(),
        ];

        return view('parent.children.show', compact(
            'student',
            'receipts',
            'totalPaid',
            'attendances',
            'attendanceStats',
            'month',
            'year'
        ));
    }

    /**
     * Download a fee receipt for a child.
     */
    public function downloadReceipt(Request $request, Student $student, FeeReceipt $receipt)
    {
        $user = $request->user();

        // Verify this child belongs to the parent and receipt belongs to child
        if (!$user->children()->where('students.id', $student->id)->exists()) {
            abort(403, 'Unauthorized access.');
        }

        if ($receipt->student_id !== $student->id) {
            abort(403, 'Receipt does not belong to this student.');
        }

        $pdfService = new ReceiptPdfService();
        return $pdfService->generate($receipt);
    }
}
