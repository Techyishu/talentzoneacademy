<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SchoolClass;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SectionController extends Controller
{
    /**
     * Display a listing of sections for a class.
     */
    public function index(SchoolClass $class)
    {
        $class->load('sections.students');

        return view('admin.sections.index', compact('class'));
    }

    /**
     * Show the form for creating a new section.
     */
    public function create(SchoolClass $class)
    {
        return view('admin.sections.create', compact('class'));
    }

    /**
     * Store a newly created section in storage.
     */
    public function store(Request $request, SchoolClass $class)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('sections', 'name')
                    ->where('school_id', session('active_school_id'))
                    ->where('class_id', $class->id),
            ],
        ]);

        $class->sections()->create($validated);

        return redirect()
            ->route('admin.sections.index', $class)
            ->with('success', 'Section created successfully.');
    }

    /**
     * Display the specified section.
     */
    public function show(SchoolClass $class, Section $section)
    {
        $section->load('students');

        return view('admin.sections.show', compact('class', 'section'));
    }

    /**
     * Show the form for editing the specified section.
     */
    public function edit(SchoolClass $class, Section $section)
    {
        return view('admin.sections.edit', compact('class', 'section'));
    }

    /**
     * Update the specified section in storage.
     */
    public function update(Request $request, SchoolClass $class, Section $section)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('sections', 'name')
                    ->where('school_id', session('active_school_id'))
                    ->where('class_id', $class->id)
                    ->ignore($section->id),
            ],
        ]);

        $section->update($validated);

        return redirect()
            ->route('admin.sections.index', $class)
            ->with('success', 'Section updated successfully.');
    }

    /**
     * Remove the specified section from storage.
     */
    public function destroy(SchoolClass $class, Section $section)
    {
        // Check if section has students
        if ($section->students()->count() > 0) {
            return redirect()
                ->route('admin.sections.index', $class)
                ->with('error', 'Cannot delete section with existing students. Please reassign students first.');
        }

        $section->delete();

        return redirect()
            ->route('admin.sections.index', $class)
            ->with('success', 'Section deleted successfully.');
    }
}
