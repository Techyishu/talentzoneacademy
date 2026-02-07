<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Staff;
use App\Http\Requests\StoreStaffRequest;
use App\Http\Requests\UpdateStaffRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;

class StaffController extends Controller
{
    /**
     * Display a listing of staff with search and filters.
     */
    public function index(Request $request)
    {
        $query = Staff::query();

        // Search by name, staff code, or phone
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('staff_code', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        // Filter by designation
        if ($request->filled('designation')) {
            $query->where('designation', $request->designation);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $staffMembers = $query->orderBy('created_at', 'desc')->paginate(15);

        // Get unique designations for filter dropdown
        $designations = Staff::select('designation')->distinct()->orderBy('designation')->pluck('designation');

        return view('admin.staff.index', compact('staffMembers', 'designations'));
    }

    /**
     * Show the form for creating a new staff member.
     */
    public function create()
    {
        return view('admin.staff.create');
    }

    /**
     * Store a newly created staff member in storage.
     */
    public function store(StoreStaffRequest $request)
    {
        $data = $request->validated();

        // Handle photo upload
        if ($request->hasFile('photo')) {
            $data['photo'] = $this->uploadPhoto($request->file('photo'));
        }

        Staff::create($data);

        return redirect()->route('admin.staff.index')
            ->with('success', 'Staff member added successfully!');
    }

    /**
     * Display the specified staff member.
     */
    public function show(Staff $staff)
    {
        return view('admin.staff.show', compact('staff'));
    }

    /**
     * Show the form for editing the specified staff member.
     */
    public function edit(Staff $staff)
    {
        return view('admin.staff.edit', compact('staff'));
    }

    /**
     * Update the specified staff member in storage.
     */
    public function update(UpdateStaffRequest $request, Staff $staff)
    {
        $data = $request->validated();

        // Handle photo upload
        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($staff->photo) {
                Storage::delete('public/' . $staff->photo);
            }
            $data['photo'] = $this->uploadPhoto($request->file('photo'));
        }

        $staff->update($data);

        return redirect()->route('admin.staff.index')
            ->with('success', 'Staff member updated successfully!');
    }

    /**
     * Remove the specified staff member from storage.
     */
    public function destroy(Staff $staff)
    {
        // Delete photo if exists
        if ($staff->photo) {
            Storage::delete('public/' . $staff->photo);
        }

        $staff->delete();

        return redirect()->route('admin.staff.index')
            ->with('success', 'Staff member deleted successfully!');
    }

    /**
     * Export staff to CSV.
     */
    public function export()
    {
        $staffMembers = Staff::orderBy('designation')->orderBy('name')->get();

        $filename = 'staff_' . date('Y-m-d') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () use ($staffMembers) {
            $file = fopen('php://output', 'w');

            // Add CSV headers
            fputcsv($file, [
                'Staff Code',
                'Name',
                'Designation',
                'Phone',
                'Joining Date',
                'Salary',
                'Status'
            ]);

            // Add data rows
            foreach ($staffMembers as $staff) {
                fputcsv($file, [
                    $staff->staff_code,
                    $staff->name,
                    $staff->designation,
                    $staff->phone,
                    $staff->joining_date,
                    $staff->salary,
                    $staff->status
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Upload and process staff photo.
     */
    private function uploadPhoto($file)
    {
        $schoolId = session('active_school_id');
        $filename = uniqid() . '_' . time() . '.' . $file->getClientOriginalExtension();
        $path = "uploads/staff-photos/{$schoolId}";

        // Create directory if it doesn't exist
        Storage::makeDirectory("public/{$path}");

        // Resize and optimize image
        $image = Image::read($file);
        $image->cover(400, 400); // Square crop for ID cards

        // Save to storage
        $fullPath = storage_path("app/public/{$path}/{$filename}");
        $image->save($fullPath);

        return "{$path}/{$filename}";
    }
}
