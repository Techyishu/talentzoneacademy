<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AcademicSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class FeeGenerationController extends Controller
{
    /**
     * Show the form for generating monthly fees.
     */
    public function showForm()
    {
        $sessions = AcademicSession::where('school_id', session('active_school_id'))
            ->orderBy('start_date', 'desc')
            ->get();

        $currentSession = AcademicSession::where('school_id', session('active_school_id'))
            ->where('is_current', true)
            ->first();

        $months = [
            1 => 'January',
            2 => 'February',
            3 => 'March',
            4 => 'April',
            5 => 'May',
            6 => 'June',
            7 => 'July',
            8 => 'August',
            9 => 'September',
            10 => 'October',
            11 => 'November',
            12 => 'December',
        ];

        return view('admin.fees.generate-monthly', compact('sessions', 'currentSession', 'months'));
    }

    /**
     * Generate monthly fees for the selected session and month.
     */
    public function generateMonthly(Request $request)
    {
        $validated = $request->validate([
            'session_id' => 'required|exists:academic_sessions,id',
            'month' => 'required|integer|min:1|max:12',
        ]);

        $schoolId = session('active_school_id');

        // Verify session belongs to current school
        $session = AcademicSession::where('id', $validated['session_id'])
            ->where('school_id', $schoolId)
            ->first();

        if (!$session) {
            return redirect()->back()
                ->with('error', 'Invalid academic session selected');
        }

        try {
            // Execute the Artisan command
            Artisan::call('fees:generate-monthly', [
                'session_id' => $validated['session_id'],
                'month' => $validated['month'],
                '--school_id' => $schoolId,
            ]);

            $output = Artisan::output();

            // Parse the output to get success count
            preg_match('/Successfully generated fees for (\d+) students/', $output, $matches);
            $studentCount = $matches[1] ?? 'all';

            $monthName = date('F', mktime(0, 0, 0, $validated['month'], 1));

            return redirect()->back()
                ->with('success', "Monthly fees generated successfully for {$studentCount} students for {$monthName} in {$session->name}!");
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to generate monthly fees: ' . $e->getMessage());
        }
    }
}
