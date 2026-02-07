<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display the staff dashboard.
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $staff = $user->staff;

        if (!$staff) {
            abort(404, 'Staff profile not found.');
        }

        // Get attendance stats for current month
        $currentMonth = now()->month;
        $currentYear = now()->year;

        $attendances = $staff->attendances()
            ->whereYear('date', $currentYear)
            ->whereMonth('date', $currentMonth)
            ->get();

        $attendanceStats = [
            'present' => $attendances->where('status', 'present')->count(),
            'absent' => $attendances->where('status', 'absent')->count(),
            'late' => $attendances->where('status', 'late')->count(),
            'leave' => $attendances->where('status', 'leave')->count(),
            'half_day' => $attendances->where('status', 'half_day')->count(),
            'total' => $attendances->count(),
        ];

        // Calculate attendance percentage
        $workingDays = $attendanceStats['total'];
        $presentDays = $attendanceStats['present'] + $attendanceStats['late'] + ($attendanceStats['half_day'] * 0.5);
        $attendancePercentage = $workingDays > 0 ? round(($presentDays / $workingDays) * 100, 1) : 0;

        // Recent attendance records
        $recentAttendance = $staff->attendances()
            ->orderBy('date', 'desc')
            ->take(10)
            ->get();

        return view('staff.dashboard', compact(
            'staff',
            'attendanceStats',
            'attendancePercentage',
            'recentAttendance',
            'currentMonth',
            'currentYear'
        ));
    }
}
