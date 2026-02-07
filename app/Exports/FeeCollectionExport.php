<?php

namespace App\Exports;

use App\Models\FeeReceipt;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class FeeCollectionExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    protected string $fromDate;
    protected string $toDate;
    protected ?string $paymentMode;

    public function __construct(string $fromDate, string $toDate, ?string $paymentMode = null)
    {
        $this->fromDate = $fromDate;
        $this->toDate = $toDate;
        $this->paymentMode = $paymentMode;
    }

    public function collection()
    {
        return FeeReceipt::with('student')
            ->where('status', 'paid')
            ->whereBetween('receipt_date', [$this->fromDate, $this->toDate])
            ->when($this->paymentMode, fn($q) => $q->where('payment_mode', $this->paymentMode))
            ->orderBy('receipt_date', 'desc')
            ->orderBy('id', 'desc')
            ->get();
    }

    public function headings(): array
    {
        return [
            'Receipt No',
            'Date',
            'Admission No',
            'Student Name',
            'Class',
            'Amount',
            'Payment Mode',
            'Reference',
        ];
    }

    public function map($receipt): array
    {
        return [
            $receipt->receipt_no,
            $receipt->receipt_date->format('d/m/Y'),
            $receipt->student->admission_no ?? '-',
            $receipt->student->name ?? '-',
            $receipt->student->schoolClass?->name ?? '-',
            number_format($receipt->amount, 2),
            ucfirst($receipt->payment_mode),
            $receipt->reference_no ?? '-',
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
