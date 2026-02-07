<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\FeeReceipt;
use App\Services\ReceiptPdfService;
use Illuminate\Http\Request;

class FeeController extends Controller
{
    /**
     * Display the student's fee history.
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $student = $user->student;

        if (!$student) {
            abort(404, 'Student profile not found.');
        }

        $receipts = FeeReceipt::where('student_id', $student->id)
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        $totalPaid = FeeReceipt::where('student_id', $student->id)->sum('amount');

        return view('student.fees.index', compact(
            'student',
            'receipts',
            'totalPaid'
        ));
    }

    /**
     * Download a fee receipt.
     */
    public function downloadReceipt(Request $request, FeeReceipt $receipt)
    {
        $user = $request->user();

        // Ensure receipt belongs to this student
        if ($receipt->student_id !== $user->student_id) {
            abort(403, 'Unauthorized access to this receipt.');
        }

        $pdfService = new ReceiptPdfService();
        return $pdfService->generate($receipt);
    }
}
