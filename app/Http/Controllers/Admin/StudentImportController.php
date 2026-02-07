<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StudentImportController extends Controller
{
    /**
     * Show the import form.
     */
    public function create()
    {
        return view('admin.students.import');
    }

    /**
     * Handle CSV import.
     */
    public function import(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt|max:10240', // 10MB max
        ]);

        $file = $request->file('csv_file');
        $csvData = array_map('str_getcsv', file($file->getRealPath()));

        // Remove header row
        $header = array_shift($csvData);

        $imported = 0;
        $failed = [];
        $schoolId = session('active_school_id');

        foreach ($csvData as $index => $row) {
            // Skip empty rows
            if (empty(array_filter($row))) {
                continue;
            }

            $data = [
                'school_id' => $schoolId,
                'admission_no' => $row[0] ?? null,
                'name' => $row[1] ?? null,
                'gender' => $row[2] ?? null,
                'dob' => $row[3] ?? null,
                'class' => $row[4] ?? null,
                'section' => $row[5] ?? null,
                'roll_no' => $row[6] ?? null,
                'guardian_name' => $row[7] ?? null,
                'guardian_phone' => $row[8] ?? null,
                'address' => $row[9] ?? null,
                'status' => $row[10] ?? 'active',
            ];

            // Validate each row
            $validator = Validator::make($data, [
                'admission_no' => 'required|unique:students,admission_no,NULL,id,school_id,' . $schoolId,
                'name' => 'required|string|max:255',
                'gender' => 'required|in:male,female,other',
                'dob' => 'required|date',
                'class' => 'required|string|max:50',
                'section' => 'nullable|string|max:50',
                'roll_no' => 'nullable|integer',
                'guardian_name' => 'required|string|max:255',
                'guardian_phone' => 'required|string|max:20',
                'address' => 'nullable|string',
                'status' => 'in:active,inactive',
            ]);

            if ($validator->fails()) {
                $failed[] = [
                    'row' => $index + 2, // +2 because header was removed and Excel starts at 1
                    'data' => $row,
                    'errors' => $validator->errors()->all(),
                ];
            } else {
                try {
                    Student::create($data);
                    $imported++;
                } catch (\Exception $e) {
                    $failed[] = [
                        'row' => $index + 2,
                        'data' => $row,
                        'errors' => ['Database error: ' . $e->getMessage()],
                    ];
                }
            }
        }

        return redirect()->route('admin.students.index')
            ->with('success', "Import completed! {$imported} students imported successfully.")
            ->with('import_failed', $failed);
    }

    /**
     * Download sample CSV template.
     */
    public function downloadTemplate()
    {
        $filename = 'student_import_template.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () {
            $file = fopen('php://output', 'w');

            // Add CSV headers
            fputcsv($file, [
                'Admission No',
                'Name',
                'Gender (male/female/other)',
                'Date of Birth (YYYY-MM-DD)',
                'Class',
                'Section',
                'Roll No',
                'Guardian Name',
                'Guardian Phone',
                'Address',
                'Status (active/inactive)'
            ]);

            // Add sample row
            fputcsv($file, [
                'STU001',
                'John Doe',
                'male',
                '2010-05-15',
                '10',
                'A',
                '1',
                'Robert Doe',
                '9876543210',
                '123 Main Street, City',
                'active'
            ]);

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
