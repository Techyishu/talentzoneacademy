<?php

namespace App\Exports;

use App\Models\SchoolClass;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class StudentsByClassExport implements FromCollection, WithHeadings, WithStyles
{
    protected string $status;

    public function __construct(string $status = 'active')
    {
        $this->status = $status;
    }

    public function collection()
    {
        $classes = SchoolClass::with(['sections' => function ($query) {
                $query->withCount(['students' => function ($q) {
                    if ($this->status !== 'all') {
                        $q->where('status', $this->status);
                    }
                }]);
            }])
            ->withCount(['students' => function ($query) {
                if ($this->status !== 'all') {
                    $query->where('status', $this->status);
                }
            }])
            ->orderBy('display_order')
            ->orderBy('name')
            ->get();

        $rows = collect();

        foreach ($classes as $class) {
            // Add class total row
            $rows->push([
                'class' => $class->name,
                'section' => 'All Sections',
                'students' => $class->students_count,
            ]);

            // Add section rows
            foreach ($class->sections as $section) {
                $rows->push([
                    'class' => $class->name,
                    'section' => $section->name,
                    'students' => $section->students_count,
                ]);
            }
        }

        return $rows;
    }

    public function headings(): array
    {
        return [
            'Class',
            'Section',
            'Students Count',
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
