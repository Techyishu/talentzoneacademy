<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Staff;
use App\Models\ContactSubmission;
use App\Models\FeeReceipt;
use App\Models\School;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $activeSchool = session('active_school_id') ? School::find(session('active_school_id')) : null;

        // Get quick stats
        if ($user->isSuperAdmin()) {
            // Super admin sees aggregate stats across all schools
            $totalStudents = Student::count();
            $totalStaff = Staff::count();
            $totalSchools = School::count();
            $recentReceipts = FeeReceipt::with(['student', 'school'])
                ->latest()
                ->limit(5)
                ->get();
        } else {
            // School admin sees stats for their school only
            $totalStudents = Student::count(); // Auto-scoped by BelongsToSchool trait
            $totalStaff = Staff::count(); // Auto-scoped by BelongsToSchool trait
            $totalSchools = null; // Not applicable for school admin
            $recentReceipts = FeeReceipt::with('student')
                ->latest()
                ->limit(5)
                ->get(); // Auto-scoped
        }

        // Get pending fee receipts count (receipts from this month)
        $pendingReceipts = FeeReceipt::whereMonth('created_at', date('m'))
            ->whereYear('created_at', date('Y'))
            ->count();

        // Contact submissions (auto-scoped by BelongsToSchool for school admins)
        $unreadContactCount = ContactSubmission::where('is_read', false)->count();
        $recentContacts = ContactSubmission::where('is_read', false)
            ->latest()
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact(
            'activeSchool',
            'totalStudents',
            'totalStaff',
            'totalSchools',
            'pendingReceipts',
            'recentReceipts',
            'unreadContactCount',
            'recentContacts'
        ));
    }
}
