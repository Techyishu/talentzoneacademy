<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreParentStudentRequest;
use App\Models\AcademicSession;
use App\Models\SchoolClass;
use App\Models\Student;
use App\Models\User;
use App\Services\FamilyFeeService;
use App\Services\FeeBalanceService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ParentStudentController extends Controller
{
    public function __construct(
        protected FamilyFeeService $familyFeeService,
        protected FeeBalanceService $feeBalanceService
    ) {
    }

    /**
     * Show the form for creating multiple students by parent.
     */
    public function create()
    {
        $classes = SchoolClass::where('school_id', session('active_school_id'))
            ->orderBy('display_order')
            ->get();

        $currentSession = AcademicSession::where('school_id', session('active_school_id'))
            ->where('is_current', true)
            ->first();

        return view('admin.parent-students.create', compact('classes', 'currentSession'));
    }

    /**
     * Store multiple students with a parent.
     */
    public function store(StoreParentStudentRequest $request)
    {
        $schoolId = session('active_school_id');

        DB::transaction(function () use ($request, $schoolId) {
            // Find or create parent user
            $parent = User::where('email', $request->parent_email)
                ->where('school_id', $schoolId)
                ->where('role', 'parent')
                ->first();

            if (! $parent) {
                $parent = User::create([
                    'name' => $request->parent_name,
                    'email' => $request->parent_email,
                    'password' => Hash::make(Str::random(12)), // Random password
                    'role' => 'parent',
                    'school_id' => $schoolId,
                ]);
            }

            $studentsCreated = 0;

            // Create each student and link to parent
            foreach ($request->students as $studentData) {
                // Create student
                $student = Student::create([
                    'school_id' => $schoolId,
                    'admission_no' => $studentData['admission_no'],
                    'name' => $studentData['name'],
                    'gender' => $studentData['gender'],
                    'dob' => $studentData['dob'],
                    'class' => $studentData['class'] ?? '',
                    'section' => $studentData['section'] ?? '',
                    'class_id' => $studentData['class_id'],
                    'section_id' => $studentData['section_id'] ?? null,
                    'roll_no' => $studentData['roll_no'] ?? null,
                    'guardian_name' => $request->parent_name,
                    'guardian_phone' => $request->parent_phone,
                    'address' => $studentData['address'] ?? '',
                    'status' => $studentData['status'] ?? 'active',
                ]);

                // Link student to parent
                $student->parents()->attach($parent->id, [
                    'relationship' => $studentData['relationship'],
                ]);

                $studentsCreated++;
            }

            // Initialize fee balances for all students and parent if current session exists
            $currentSession = AcademicSession::where('school_id', $schoolId)
                ->where('is_current', true)
                ->first();

            if ($currentSession) {
                foreach ($parent->children as $child) {
                    if ($child->class_id) {
                        $this->feeBalanceService->initializeBalances($child, $currentSession->id);
                    }
                }

                // Initialize parent family balance
                $this->familyFeeService->initializeFamilyBalances($parent, $currentSession->id);
            }

            session()->flash('success', "Family account created successfully with {$studentsCreated} student(s)!");
        });

        return redirect()->route('admin.students.index');
    }
}
