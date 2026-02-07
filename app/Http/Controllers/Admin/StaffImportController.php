<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StaffImportController extends Controller
{
    /**
     * Show the import form.
     */
    public function create()
    {
        return view('admin.staff.import');
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
                'staff_code' => $row[0] ?? null,
                'name' => $row[1] ?? null,
                'designation' => $row[2] ?? null,
                'phone' => $row[3] ?? null,
                'joining_date' => $row[4] ?? null,
                'salary' => $row[5] ?? null,
                'status' => $row[6] ?? 'active',
            ];

            // Validate each row
            $validator = Validator::make($data, [
                'staff_code' => 'required|unique:staff,staff_code,NULL,id,school_id,' . $schoolId,
                'name' => 'required|string|max:255',
                'designation' => 'required|string|max:255',
                'phone' => 'required|string|max:20',
                'joining_date' => 'required|date',
                'salary' => 'nullable|numeric|min:0',
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
                    Staff::create($data);
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

        return redirect()->route('admin.staff.index')
            ->with('success', "Import completed! {$imported} staff members imported successfully.")
            ->with('import_failed', $failed);
    }

    /**
     * Download sample CSV template.
     */
    public function downloadTemplate()
    {
        $filename = 'staff_import_template.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () {
            $file = fopen('php://output', 'w');

            // Add CSV headers
            fputcsv($file, [
                'Staff Code',
                'Name',
                'Designation',
                'Phone',
                'Joining Date (YYYY-MM-DD)',
                'Salary (optional)',
                'Status (active/inactive)'
            ]);

            // Add sample row
            fputcsv($file, [
                'STF001',
                'John Smith',
                'Teacher',
                '9876543210',
                '2020-01-15',
                '50000',
                'active'
            ]);

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
