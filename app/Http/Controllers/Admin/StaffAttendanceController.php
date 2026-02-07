<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Staff;
use App\Models\StaffAttendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StaffAttendanceController extends Controller
{
    /**
     * Display attendance list with date filter.
     */
    public function index(Request $request)
    {
        $date = $request->get('date', now()->toDateString());

        $attendances = StaffAttendance::with('staff')
            ->forDate($date)
            ->orderBy('created_at', 'desc')
            ->paginate(50);

        // Get summary stats
        $stats = StaffAttendance::forDate($date)
            ->selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status');

        return view('admin.staff-attendance.index', compact(
            'attendances',
            'date',
            'stats'
        ));
    }

    /**
     * Show form to mark attendance.
     */
    public function create(Request $request)
    {
        $date = $request->get('date', now()->toDateString());

        $staff = Staff::where('status', 'active')
            ->orderBy('name')
            ->get();

        // Get existing attendance for this date
        $existingAttendance = StaffAttendance::forDate($date)
            ->whereIn('staff_id', $staff->pluck('id'))
            ->get()
            ->keyBy('staff_id');

        return view('admin.staff-attendance.create', compact(
            'date',
            'staff',
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
            'attendance.*.staff_id' => 'required|exists:staff,id',
            'attendance.*.status' => 'required|in:present,absent,late,leave,half_day',
        ]);

        $date = $request->input('date');
        $attendanceData = $request->input('attendance', []);
        $checkIn = $request->input('check_in', []);
        $checkOut = $request->input('check_out', []);
        $remarks = $request->input('remarks', []);

        DB::transaction(function () use ($date, $attendanceData, $checkIn, $checkOut, $remarks) {
            foreach ($attendanceData as $data) {
                $staffId = $data['staff_id'];

                StaffAttendance::updateOrCreate(
                    [
                        'school_id' => session('active_school_id'),
                        'staff_id' => $staffId,
                        'date' => $date,
                    ],
                    [
                        'status' => $data['status'],
                        'check_in' => $checkIn[$staffId] ?? null,
                        'check_out' => $checkOut[$staffId] ?? null,
                        'remarks' => $remarks[$staffId] ?? null,
                    ]
                );
            }
        });

        $count = count($attendanceData);

        return redirect()
            ->route('admin.staff-attendance.index', ['date' => $date])
            ->with('success', "Attendance marked for {$count} staff members.");
    }

    /**
     * View attendance history for a specific staff member.
     */
    public function staffHistory(Staff $staff, Request $request)
    {
        $month = $request->get('month', now()->month);
        $year = $request->get('year', now()->year);

        $attendances = $staff->attendances()
            ->whereYear('date', $year)
            ->whereMonth('date', $month)
            ->orderBy('date', 'desc')
            ->get();

        // Calculate monthly stats
        $stats = $attendances->groupBy('status')->map->count();
        $totalDays = $attendances->count();

        return view('admin.staff-attendance.history', compact(
            'staff',
            'attendances',
            'month',
            'year',
            'stats',
            'totalDays'
        ));
    }
}
