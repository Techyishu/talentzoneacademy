<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\User;
use App\Models\AcademicSession;
use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateStudentRequest;
use App\Services\FamilyFeeService;
use App\Services\FeeBalanceService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Intervention\Image\Laravel\Facades\Image;

class StudentController extends Controller
{
    public function __construct(
        protected FamilyFeeService $familyFeeService,
        protected FeeBalanceService $feeBalanceService
    ) {
    }

    /**
     * Display a listing of students with search and filters.
     */
    public function index(Request $request)
    {
        $query = Student::query();

        // Search by name, admission number, or guardian
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('admission_no', 'like', "%{$search}%")
                    ->orWhere('guardian_name', 'like', "%{$search}%");
            });
        }

        // Filter by class
        if ($request->filled('class')) {
            $query->where('class', $request->class);
        }

        // Filter by section
        if ($request->filled('section')) {
            $query->where('section', $request->section);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $students = $query->with('parents')->orderBy('created_at', 'desc')->paginate(15);

        // Get unique classes and sections for filter dropdowns
        $classes = Student::select('class')->distinct()->orderBy('class')->pluck('class');
        $sections = Student::select('section')->distinct()->orderBy('section')->pluck('section');

        return view('admin.students.index', compact('students', 'classes', 'sections'));
    }

    /**
     * Show the form for creating a new student.
     */
    public function create()
    {
        $classes = \App\Models\SchoolClass::where('school_id', session('active_school_id'))
            ->orderBy('display_order')
            ->get();

        return view('admin.students.create', compact('classes'));
    }

    /**
     * Store a newly created student in storage.
     */
    public function store(StoreStudentRequest $request)
    {
        $data = $request->validated();

        // Handle photo upload
        if ($request->hasFile('photo')) {
            $data['photo'] = $this->uploadPhoto($request->file('photo'));
        }

        // Create student
        $student = Student::create($data);

        // Handle parent linking if requested
        if ($request->filled('link_parent') && $request->link_parent) {
            $this->linkParentToStudent($request, $student);
        }

        return redirect()->route('admin.students.index')
            ->with('success', 'Student created successfully!' .
                ($request->link_parent ? ' Parent account linked.' : ''));
    }

    /**
     * Link a parent to a student.
     */
    protected function linkParentToStudent(StoreStudentRequest $request, Student $student): void
    {
        $schoolId = session('active_school_id');

        // Check if parent already exists by email
        $parent = User::where('email', $request->parent_email)
            ->where('school_id', $schoolId)
            ->where('role', 'parent')
            ->first();

        // Create parent account if requested and doesn't exist
        if (!$parent && $request->filled('create_parent_account') && $request->create_parent_account) {
            $parent = User::create([
                'name' => $request->parent_name,
                'email' => $request->parent_email,
                'password' => Hash::make(Str::random(12)), // Random password, can be reset
                'role' => 'parent',
                'school_id' => $schoolId,
            ]);
        }

        // If parent exists or was created, link to student
        if ($parent) {
            // Create parent-student link
            $student->parents()->attach($parent->id, [
                'relationship' => $request->relationship,
            ]);

            // Initialize student fee balances if current session exists
            $currentSession = AcademicSession::where('school_id', $schoolId)
                ->where('is_current', true)
                ->first();

            if ($currentSession && $student->class_id) {
                // Initialize student balances
                $this->feeBalanceService->initializeBalances($student, $currentSession->id);

                // Initialize or update parent family balance
                $this->familyFeeService->initializeFamilyBalances($parent, $currentSession->id);
            }
        }
    }

    /**
     * Display the specified student.
     */
    public function show(Student $student)
    {
        // Load relationships for student details
        $student->load([
            'feeReceipts' => function ($query) {
                $query->latest()->limit(10);
            }
        ]);

        return view('admin.students.show', compact('student'));
    }

    /**
     * Show the form for editing the specified student.
     */
    public function edit(Student $student)
    {
        $classes = \App\Models\SchoolClass::where('school_id', session('active_school_id'))
            ->orderBy('display_order')
            ->get();

        // Load sections for the student's current class if set
        $sections = $student->class_id
            ? \App\Models\Section::where('class_id', $student->class_id)->orderBy('name')->get()
            : collect();

        return view('admin.students.edit', compact('student', 'classes', 'sections'));
    }

    /**
     * Update the specified student in storage.
     */
    public function update(UpdateStudentRequest $request, Student $student)
    {
        $data = $request->validated();

        // Handle photo upload
        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($student->photo) {
                Storage::delete('public/' . $student->photo);
            }
            $data['photo'] = $this->uploadPhoto($request->file('photo'));
        }

        $student->update($data);

        return redirect()->route('admin.students.index')
            ->with('success', 'Student updated successfully!');
    }

    /**
     * Remove the specified student from storage.
     */
    public function destroy(Student $student)
    {
        // Delete photo if exists
        if ($student->photo) {
            Storage::delete('public/' . $student->photo);
        }

        $student->delete();

        return redirect()->route('admin.students.index')
            ->with('success', 'Student deleted successfully!');
    }

    /**
     * Export students to CSV.
     */
    public function export()
    {
        $students = Student::orderBy('class')->orderBy('section')->orderBy('roll_no')->get();

        $filename = 'students_' . date('Y-m-d') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () use ($students) {
            $file = fopen('php://output', 'w');

            // Add CSV headers
            fputcsv($file, [
                'Admission No',
                'Name',
                'Gender',
                'Date of Birth',
                'Class',
                'Section',
                'Roll No',
                'Guardian Name',
                'Guardian Phone',
                'Address',
                'Status'
            ]);

            // Add data rows
            foreach ($students as $student) {
                fputcsv($file, [
                    $student->admission_no,
                    $student->name,
                    $student->gender,
                    $student->dob,
                    $student->class,
                    $student->section,
                    $student->roll_no,
                    $student->guardian_name,
                    $student->guardian_phone,
                    $student->address,
                    $student->status
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Upload and process student photo.
     */
    private function uploadPhoto($file)
    {
        $schoolId = session('active_school_id');
        $filename = uniqid() . '_' . time() . '.' . $file->getClientOriginalExtension();
        $path = "uploads/student-photos/{$schoolId}";

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
