<?php

namespace App\Http\Controllers\ParentPortal;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display the parent dashboard.
     */
    public function index(Request $request)
    {
        $user = $request->user();

        // Get linked children
        $children = $user->children()->with(['schoolClass', 'schoolSection'])->get();

        // Aggregate stats across all children
        $totalFeePaid = 0;
        $childrenData = [];

        foreach ($children as $child) {
            $feePaid = $child->feeReceipts()->sum('amount');
            $totalFeePaid += $feePaid;

            // Get current month attendance
            $attendances = $child->attendances()
                ->whereYear('date', now()->year)
                ->whereMonth('date', now()->month)
                ->get();

            $attendanceStats = [
                'present' => $attendances->where('status', 'present')->count(),
                'absent' => $attendances->where('status', 'absent')->count(),
                'late' => $attendances->where('status', 'late')->count(),
                'total' => $attendances->count(),
            ];

            $childrenData[] = [
                'student' => $child,
                'fee_paid' => $feePaid,
                'attendance' => $attendanceStats,
            ];
        }

        return view('parent.dashboard', compact(
            'children',
            'childrenData',
            'totalFeePaid'
        ));
    }
}
