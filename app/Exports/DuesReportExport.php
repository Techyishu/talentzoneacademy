<?php

namespace App\Exports;

use App\Models\Student;
use App\Services\FeeBalanceService;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class DuesReportExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    protected int $sessionId;
    protected ?int $classId;
    protected ?int $sectionId;
    protected FeeBalanceService $balanceService;

    public function __construct(int $sessionId, ?int $classId, ?int $sectionId, FeeBalanceService $balanceService)
    {
        $this->sessionId = $sessionId;
        $this->classId = $classId;
        $this->sectionId = $sectionId;
        $this->balanceService = $balanceService;
    }

    public function collection()
    {
        $query = Student::where('status', 'active')
            ->with(['schoolClass', 'schoolSection']);

        if ($this->classId) {
            $query->where('class_id', $this->classId);
        }
        if ($this->sectionId) {
            $query->where('section_id', $this->sectionId);
        }

        $students = $query->orderBy('name')->get();

        // Filter to only students with dues
        return $students->filter(function ($student) {
            $summary = $this->balanceService->getBalanceSummary($student, $this->sessionId);
            $student->dues_summary = $summary;
            return $summary['total_balance'] > 0;
        });
    }

    public function headings(): array
    {
        return [
            'Admission No',
            'Student Name',
            'Class',
            'Section',
            'Father Name',
            'Phone',
            'Total Due',
            'Total Paid',
            'Balance',
        ];
    }

    public function map($student): array
    {
        return [
            $student->admission_no,
            $student->name,
            $student->schoolClass?->name ?? '-',
            $student->schoolSection?->name ?? '-',
            $student->father_name,
            $student->phone,
            number_format($student->dues_summary['total_due'], 2),
            number_format($student->dues_summary['total_paid'], 2),
            number_format($student->dues_summary['total_balance'], 2),
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
