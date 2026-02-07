<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AcademicSession;
use App\Models\FeeHead;
use App\Models\FeeReceipt;
use App\Models\FeeReceiptItem;
use App\Models\SchoolClass;
use App\Models\Section;
use App\Models\Student;
use App\Models\StudentFeeBalance;
use App\Services\FeeBalanceService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\DuesReportExport;
use App\Exports\FeeCollectionExport;
use App\Exports\StudentsByClassExport;

class DuesReportController extends Controller
{
    protected FeeBalanceService $balanceService;

    public function __construct(FeeBalanceService $balanceService)
    {
        $this->balanceService = $balanceService;
    }

    /**
     * Display the pending dues report.
     */
    public function index(Request $request)
    {
        $sessions = AcademicSession::orderBy('start_date', 'desc')->get();
        $classes = SchoolClass::orderBy('display_order')->orderBy('name')->get();

        // Get selected filters
        $sessionId = $request->get('session_id');
        $classId = $request->get('class_id');
        $sectionId = $request->get('section_id');

        // Default to current session if not specified
        if (!$sessionId) {
            $currentSession = $sessions->firstWhere('is_current', true);
            $sessionId = $currentSession?->id;
        }

        // Get sections for selected class (for AJAX filter)
        $sections = $classId ? Section::where('class_id', $classId)->orderBy('name')->get() : collect();

        // Build query for students with dues
        $studentsWithDues = collect();
        $totals = ['total_due' => 0, 'total_paid' => 0, 'total_balance' => 0];

        if ($sessionId) {
            $query = Student::where('status', 'active')
                ->with(['schoolClass', 'schoolSection']);

            if ($classId) {
                $query->where('class_id', $classId);
            }
            if ($sectionId) {
                $query->where('section_id', $sectionId);
            }

            // Get students who have pending dues
            $students = $query->orderBy('name')->get();

            foreach ($students as $student) {
                $summary = $this->balanceService->getBalanceSummary($student, $sessionId);

                // Only include students with outstanding balance
                if ($summary['total_balance'] > 0) {
                    $studentsWithDues->push([
                        'student' => $student,
                        'summary' => $summary,
                    ]);

                    $totals['total_due'] += $summary['total_due'];
                    $totals['total_paid'] += $summary['total_paid'];
                    $totals['total_balance'] += $summary['total_balance'];
                }
            }
        }

        return view('admin.reports.dues', compact(
            'sessions',
            'classes',
            'sections',
            'studentsWithDues',
            'totals',
            'sessionId',
            'classId',
            'sectionId'
        ));
    }

    /**
     * Get sections for a class (AJAX).
     */
    public function getSections(SchoolClass $class)
    {
        $sections = $class->sections()->orderBy('name')->get(['id', 'name']);
        return response()->json($sections);
    }

    /**
     * Export dues report to Excel.
     */
    public function export(Request $request)
    {
        $sessionId = $request->get('session_id');
        $classId = $request->get('class_id');
        $sectionId = $request->get('section_id');

        if (!$sessionId) {
            return back()->with('error', 'Please select an academic session.');
        }

        return Excel::download(
            new DuesReportExport($sessionId, $classId, $sectionId, $this->balanceService),
            'pending-dues-report.xlsx'
        );
    }

    /**
     * Show detailed dues for a specific student.
     */
    public function studentDues(Request $request, Student $student)
    {
        $sessionId = $request->get('session_id');

        if (!$sessionId) {
            $currentSession = AcademicSession::where('is_current', true)->first();
            $sessionId = $currentSession?->id;
        }

        $summary = $sessionId ? $this->balanceService->getBalanceSummary($student, $sessionId) : null;
        $sessions = AcademicSession::orderBy('start_date', 'desc')->get();

        return view('admin.reports.student-dues', compact('student', 'summary', 'sessions', 'sessionId'));
    }
}
