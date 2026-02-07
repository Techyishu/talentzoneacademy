<?php

namespace App\Services;

use App\Models\FeeReceipt;
use Barryvdh\DomPDF\Facade\Pdf;

class ReceiptPdfService
{
    /**
     * Generate PDF for a fee receipt.
     */
    public function generate(FeeReceipt $receipt)
    {
        $receipt->load(['student', 'school']);

        $pdf = Pdf::loadView('pdf.receipt', [
            'receipt' => $receipt,
            'school' => $receipt->school,
            'student' => $receipt->student,
        ]);

        // Set paper size to A4
        $pdf->setPaper('a4', 'portrait');

        return $pdf;
    }

    /**
     * Download PDF for a fee receipt.
     */
    public function download(FeeReceipt $receipt)
    {
        $filename = 'receipt_' . $receipt->receipt_no . '.pdf';
        return $this->generate($receipt)->download($filename);
    }

    /**
     * Stream PDF for a fee receipt.
     */
    public function stream(FeeReceipt $receipt)
    {
        $filename = 'receipt_' . $receipt->receipt_no . '.pdf';
        return $this->generate($receipt)->stream($filename);
    }
}
