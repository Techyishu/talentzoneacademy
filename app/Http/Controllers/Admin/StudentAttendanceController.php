<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SchoolClass;
use App\Models\Section;
use App\Models\Student;
use App\Models\StudentAttendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StudentAttendanceController extends Controller
{
    /**
     * Display attendance list with date filter.
     */
    public function index(Request $request)
    {
        $date = $request->get('date', now()->toDateString());
        $classId = $request->get('class_id');
        $sectionId = $request->get('section_id');

        $query = StudentAttendance::with(['student.schoolClass', 'student.schoolSection'])
            ->forDate($date);

        if ($classId) {
            $query->whereHas('student', fn($q) => $q->where('class_id', $classId));
        }

        if ($sectionId) {
            $query->whereHas('student', fn($q) => $q->where('section_id', $sectionId));
        }

        $attendances = $query->orderBy('created_at', 'desc')->paginate(50);

        // Get summary stats
        $stats = StudentAttendance::forDate($date)
            ->selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status');

        $classes = SchoolClass::orderBy('display_order')->orderBy('name')->get();
        $sections = $classId ? Section::where('class_id', $classId)->get() : collect();

        return view('admin.student-attendance.index', compact(
            'attendances',
            'date',
            'classId',
            'sectionId',
            'classes',
            'sections',
            'stats'
        ));
    }

    /**
     * Show form to mark attendance.
     */
    public function create(Request $request)
    {
        $date = $request->get('date', now()->toDateString());
        $classId = $request->get('class_id');
        $sectionId = $request->get('section_id');

        $classes = SchoolClass::orderBy('display_order')->orderBy('name')->get();
        $sections = $classId ? Section::where('class_id', $classId)->get() : collect();

        $students = collect();
        $existingAttendance = collect();

        if ($classId) {
            $studentsQuery = Student::where('status', 'active')
                ->where('class_id', $classId);

            if ($sectionId) {
                $studentsQuery->where('section_id', $sectionId);
            }

            $students = $studentsQuery->orderBy('roll_no')->orderBy('name')->get();

            // Get existing attendance for this date
            $existingAttendance = StudentAttendance::forDate($date)
                ->whereIn('student_id', $students->pluck('id'))
                ->get()
                ->keyBy('student_id');
        }

        return view('admin.student-attendance.create', compact(
            'date',
            'classId',
            'sectionId',
            'classes',
            'sections',
            'students',
            'existingAttendance'
        ));
    }

    /**
     * Store attendance records (bulk).
     */
    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'attendance' => 'required|array',
            'attendance.*.student_id' => 'required|exists:students,id',
            'attendance.*.status' => 'required|in:present,absent,late,leave',
        ]);

        $date = $request->input('date');
        $attendanceData = $request->input('attendance', []);
        $remarks = $request->input('remarks', []);

        DB::transaction(function () use ($date, $attendanceData, $remarks) {
            foreach ($attendanceData as $data) {
                StudentAttendance::updateOrCreate(
                    [
                        'school_id' => session('active_school_id'),
                        'student_id' => $data['student_id'],
                        'date' => $date,
                    ],
                    [
                        'status' => $data['status'],
                        'remarks' => $remarks[$data['student_id']] ?? null,
                    ]
                );
            }
        });

        $count = count($attendanceData);

        return redirect()
            ->route('admin.student-attendance.index', ['date' => $date])
            ->with('success', "Attendance marked for {$count} students.");
    }

    /**
     * View attendance for a specific date.
     */
    public function show(string $date, Request $request)
    {
        $classId = $request->get('class_id');
        $sectionId = $request->get('section_id');

        $query = StudentAttendance::with(['student.schoolClass', 'student.schoolSection'])
            ->forDate($date);

        if ($classId) {
            $query->whereHas('student', fn($q) => $q->where('class_id', $classId));
        }

        if ($sectionId) {
            $query->whereHas('student', fn($q) => $q->where('section_id', $sectionId));
        }

        $attendances = $query->get();

        // Get summary stats
        $stats = $attendances->groupBy('status')->map->count();

        $classes = SchoolClass::orderBy('display_order')->orderBy('name')->get();
        $sections = $classId ? Section::where('class_id', $classId)->get() : collect();

        return view('admin.student-attendance.show', compact(
            'attendances',
            'date',
            'classId',
            'sectionId',
            'classes',
            'sections',
            'stats'
        ));
    }

    /**
     * View attendance history for a specific student.
     */
    public function studentHistory(Student $student, Request $request)
    {
        $month = $request->get('month', now()->month);
        $year = $request->get('year', now()->year);

        $attendances = $student->attendances()
            ->whereYear('date', $year)
            ->whereMonth('date', $month)
            ->orderBy('date', 'desc')
            ->get();

        // Calculate monthly stats
        $stats = $attendances->groupBy('status')->map->count();
        $totalDays = $attendances->count();

        return view('admin.student-attendance.history', compact(
            'student',
            'attendances',
            'month',
            'year',
            'stats',
            'totalDays'
        ));
    }

    /**
     * Quick attendance view for a section (all present by default).
     */
    public function quickAttendance(Request $request, SchoolClass $class, Section $section)
    {
        $date = $request->get('date', now()->toDateString());

        $students = Student::where('status', 'active')
            ->where('class_id', $class->id)
            ->where('section_id', $section->id)
            ->orderBy('roll_no')
            ->orderBy('name')
            ->get();

        // Get existing attendance for this date
        $existingAttendance = StudentAttendance::forDate($date)
            ->whereIn('student_id', $students->pluck('id'))
            ->get()
            ->keyBy('student_id');

        return view('admin.student-attendance.quick-attendance', compact(
            'class',
            'section',
            'students',
            'date',
            'existingAttendance'
        ));
    }

    /**
     * Store quick attendance (all present except specified absent students).
     */
    public function storeQuick(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'class_id' => 'required|exists:classes,id',
            'section_id' => 'required|exists:sections,id',
            'absent_students' => 'nullable|array',
            'absent_students.*' => 'exists:students,id',
        ]);

        $date = $request->input('date');
        $classId = $request->input('class_id');
        $sectionId = $request->input('section_id');
        $absentStudentIds = $request->input('absent_students', []);

        // Get all active students in the section
        $students = Student::where('status', 'active')
            ->where('class_id', $classId)
            ->where('section_id', $sectionId)
            ->get();

        DB::transaction(function () use ($date, $students, $absentStudentIds) {
            foreach ($students as $student) {
                $status = in_array($student->id, $absentStudentIds) ? 'absent' : 'present';

                StudentAttendance::updateOrCreate(
                    [
                        'school_id' => session('active_school_id'),
                        'student_id' => $student->id,
                        'date' => $date,
                    ],
                    [
                        'status' => $status,
                    ]
                );
            }
        });

        $presentCount = $students->count() - count($absentStudentIds);
        $absentCount = count($absentStudentIds);

        return redirect()
            ->route('admin.student-attendance.quick', ['class' => $classId, 'section' => $sectionId, 'date' => $date])
            ->with('success', "Attendance saved! Present: {$presentCount}, Absent: {$absentCount}");
    }

    /**
     * Get sections for a class (AJAX).
     */
    public function getSections(SchoolClass $class)
    {
        $sections = $class->sections()->get(['id', 'name']);
        return response()->json($sections);
    }
}
