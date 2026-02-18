<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SchoolClass;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ClassController extends Controller
{
    /**
     * Display a listing of the classes.
     */
    public function index()
    {
        $classes = SchoolClass::with(['sections.students', 'students'])
            ->orderBy('display_order')
            ->orderBy('name')
            ->get();

        return view('admin.classes.index', compact('classes'));
    }

    /**
     * Show the form for creating a new class.
     */
    public function create()
    {
        return view('admin.classes.create');
    }

    /**
     * Store a newly created class in storage.
     */
    public function store(Request $request)
    {
        $schoolId = session('active_school_id');

        abort_unless($schoolId, 403, 'No active school selected.');

        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('classes', 'name')->where('school_id', $schoolId),
            ],
            'display_order' => 'nullable|integer|min:0',
            'sections' => 'nullable|array',
            'sections.*' => 'string|max:50',
        ]);

        $sections = $validated['sections'] ?? [];
        unset($validated['sections']);

        $class = SchoolClass::create(array_merge($validated, ['school_id' => $schoolId]));

        // Create sections if provided
        foreach ($sections as $sectionName) {
            $class->sections()->create([
                'school_id' => $schoolId,
                'name' => trim($sectionName),
            ]);
        }

        return redirect()
            ->route('admin.classes.index')
            ->with('success', 'Class created successfully' . (count($sections) > 0 ? ' with ' . count($sections) . ' section(s).' : '.'));
    }

    /**
     * Display the specified class.
     */
    public function show(SchoolClass $class)
    {
        $class->load(['sections', 'students']);

        return view('admin.classes.show', compact('class'));
    }

    /**
     * Show the form for editing the specified class.
     */
    public function edit(SchoolClass $class)
    {
        return view('admin.classes.edit', compact('class'));
    }

    /**
     * Update the specified class in storage.
     */
    public function update(Request $request, SchoolClass $class)
    {
        $schoolId = session('active_school_id');

        abort_unless($schoolId, 403, 'No active school selected.');

        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('classes', 'name')
                    ->where('school_id', $schoolId)
                    ->ignore($class->id),
            ],
            'display_order' => 'nullable|integer|min:0',
        ]);

        $class->update($validated);

        return redirect()
            ->route('admin.classes.index')
            ->with('success', 'Class updated successfully.');
    }

    /**
     * Remove the specified class from storage.
     */
    public function destroy(SchoolClass $class)
    {
        // Check if class has students
        if ($class->students()->count() > 0) {
            return redirect()
                ->route('admin.classes.index')
                ->with('error', 'Cannot delete class with existing students. Please reassign students first.');
        }

        $class->delete();

        return redirect()
            ->route('admin.classes.index')
            ->with('success', 'Class deleted successfully.');
    }

    /**
     * Get sections for a class as JSON (for AJAX requests).
     */
    public function sectionsApi(SchoolClass $class)
    {
        $sections = $class->sections()->orderBy('name')->get(['id', 'name']);

        return response()->json($sections);
    }
}
