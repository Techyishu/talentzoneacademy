<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\FeeReceipt;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display the student dashboard.
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $student = $user->student;

        if (!$student) {
            abort(404, 'Student profile not found.');
        }

        // Get fee receipts
        $recentReceipts = FeeReceipt::where('student_id', $student->id)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        $totalPaid = FeeReceipt::where('student_id', $student->id)->sum('amount');

        // Get attendance stats for current month
        $currentMonth = now()->month;
        $currentYear = now()->year;

        $attendances = $student->attendances()
            ->whereYear('date', $currentYear)
            ->whereMonth('date', $currentMonth)
            ->get();

        $attendanceStats = [
            'present' => $attendances->where('status', 'present')->count(),
            'absent' => $attendances->where('status', 'absent')->count(),
            'late' => $attendances->where('status', 'late')->count(),
            'leave' => $attendances->where('status', 'leave')->count(),
            'total' => $attendances->count(),
        ];

        // Calculate attendance percentage
        $workingDays = $attendanceStats['total'];
        $presentDays = $attendanceStats['present'] + $attendanceStats['late'];
        $attendancePercentage = $workingDays > 0 ? round(($presentDays / $workingDays) * 100, 1) : 0;

        return view('student.dashboard', compact(
            'student',
            'recentReceipts',
            'totalPaid',
            'attendanceStats',
            'attendancePercentage',
            'currentMonth',
            'currentYear'
        ));
    }
}
