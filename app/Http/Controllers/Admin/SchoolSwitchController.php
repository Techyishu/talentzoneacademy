<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\School;
use Illuminate\Http\Request;

class SchoolSwitchController extends Controller
{
    public function switch(Request $request)
    {
        // Ensure only super admins can switch schools
        if (!auth()->user()->isSuperAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'school_id' => 'required|exists:schools,id'
        ]);

        $school = School::findOrFail($request->school_id);

        // Update the active school in session
        session(['active_school_id' => $school->id]);

        return redirect()->route('admin.dashboard')->with('success', "Switched to {$school->name}");
    }
}
