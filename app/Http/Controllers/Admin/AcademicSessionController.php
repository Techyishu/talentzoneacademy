<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AcademicSession;
use Illuminate\Http\Request;

class AcademicSessionController extends Controller
{
    /**
     * Display a listing of academic sessions.
     */
    public function index()
    {
        $sessions = AcademicSession::where('school_id', session('active_school_id'))
            ->orderBy('start_date', 'desc')
            ->paginate(15);

        return view('admin.academic-sessions.index', compact('sessions'));
    }

    /**
     * Show the form for creating a new academic session.
     */
    public function create()
    {
        return view('admin.academic-sessions.create');
    }

    /**
     * Store a newly created academic session in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'is_current' => 'boolean',
        ]);

        $validated['school_id'] = session('active_school_id');
        $validated['is_current'] = $request->has('is_current');

        // Check if name is unique for this school
        $exists = AcademicSession::where('school_id', $validated['school_id'])
            ->where('name', $validated['name'])
            ->exists();

        if ($exists) {
            return back()->withErrors(['name' => 'An academic session with this name already exists for your school.'])->withInput();
        }

        $session = AcademicSession::create($validated);

        // If marked as current, unset other current sessions
        if ($session->is_current) {
            $session->makeCurrent();
        }

        return redirect()->route('admin.academic-sessions.index')
            ->with('success', 'Academic session created successfully.');
    }

    /**
     * Show the form for editing the specified academic session.
     */
    public function edit(AcademicSession $academicSession)
    {
        return view('admin.academic-sessions.edit', compact('academicSession'));
    }

    /**
     * Update the specified academic session in storage.
     */
    public function update(Request $request, AcademicSession $academicSession)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'is_current' => 'boolean',
        ]);

        $validated['is_current'] = $request->has('is_current');

        // Check if name is unique for this school (excluding current record)
        $exists = AcademicSession::where('school_id', $academicSession->school_id)
            ->where('name', $validated['name'])
            ->where('id', '!=', $academicSession->id)
            ->exists();

        if ($exists) {
            return back()->withErrors(['name' => 'An academic session with this name already exists for your school.'])->withInput();
        }

        $academicSession->update($validated);

        // If marked as current, unset other current sessions
        if ($academicSession->is_current) {
            $academicSession->makeCurrent();
        }

        return redirect()->route('admin.academic-sessions.index')
            ->with('success', 'Academic session updated successfully.');
    }

    /**
     * Remove the specified academic session from storage.
     */
    public function destroy(AcademicSession $academicSession)
    {
        // Prevent deletion if it's the current session
        if ($academicSession->is_current) {
            return back()->with('error', 'Cannot delete the current academic session. Please set another session as current first.');
        }

        $academicSession->delete();

        return redirect()->route('admin.academic-sessions.index')
            ->with('success', 'Academic session deleted successfully.');
    }

    /**
     * Toggle the current status of an academic session.
     */
    public function toggleCurrent(AcademicSession $academicSession)
    {
        if ($academicSession->is_current) {
            return back()->with('error', 'This session is already marked as current.');
        }

        $academicSession->makeCurrent();

        // Update session context
        session(['active_session_id' => $academicSession->id]);

        return back()->with('success', 'Academic session set as current successfully.');
    }
}
