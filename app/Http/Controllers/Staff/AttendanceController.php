<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    /**
     * Display the staff's attendance history.
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $staff = $user->staff;

        if (!$staff) {
            abort(404, 'Staff profile not found.');
        }

        $month = $request->get('month', now()->month);
        $year = $request->get('year', now()->year);

        $attendances = $staff->attendances()
            ->whereYear('date', $year)
            ->whereMonth('date', $month)
            ->orderBy('date', 'desc')
            ->get();

        // Monthly stats
        $stats = [
            'present' => $attendances->where('status', 'present')->count(),
            'absent' => $attendances->where('status', 'absent')->count(),
            'late' => $attendances->where('status', 'late')->count(),
            'leave' => $attendances->where('status', 'leave')->count(),
            'half_day' => $attendances->where('status', 'half_day')->count(),
            'total' => $attendances->count(),
        ];

        return view('staff.attendance.index', compact(
            'staff',
            'attendances',
            'stats',
            'month',
            'year'
        ));
    }
}
