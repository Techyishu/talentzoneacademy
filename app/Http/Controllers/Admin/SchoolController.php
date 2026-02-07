<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSchoolRequest;
use App\Http\Requests\UpdateSchoolRequest;
use App\Models\School;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;

class SchoolController extends Controller
{
    /**
     * Display a listing of schools
     */
    public function index()
    {
        $schools = School::withCount(['students', 'staff', 'users'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.schools.index', compact('schools'));
    }

    /**
     * Show the form for creating a new school
     */
    public function create()
    {
        return view('admin.schools.create');
    }

    /**
     * Store a newly created school
     */
    public function store(StoreSchoolRequest $request)
    {
        $data = $request->validated();

        // Handle logo upload
        if ($request->hasFile('logo')) {
            $data['logo'] = $this->uploadLogo($request->file('logo'));
        }

        // Handle signature upload
        if ($request->hasFile('signature_image')) {
            $data['signature_image'] = $this->uploadSignature($request->file('signature_image'));
        }

        School::create($data);

        return redirect()->route('admin.schools.index')
            ->with('success', 'School created successfully.');
    }

    /**
     * Display the specified school
     */
    public function show(School $school)
    {
        $school->load(['users', 'students', 'staff']);

        $stats = [
            'students' => $school->students()->count(),
            'staff' => $school->staff()->count(),
            'users' => $school->users()->count(),
            'pages' => $school->pages()->count(),
            'gallery_images' => $school->galleryImages()->count(),
        ];

        return view('admin.schools.show', compact('school', 'stats'));
    }

    /**
     * Show the form for editing the specified school
     */
    public function edit(School $school)
    {
        return view('admin.schools.edit', compact('school'));
    }

    /**
     * Update the specified school
     */
    public function update(UpdateSchoolRequest $request, School $school)
    {
        $data = $request->validated();

        // Handle logo upload
        if ($request->hasFile('logo')) {
            // Delete old logo
            if ($school->logo) {
                Storage::disk('public')->delete($school->logo);
            }
            $data['logo'] = $this->uploadLogo($request->file('logo'));
        }

        // Handle signature upload
        if ($request->hasFile('signature_image')) {
            // Delete old signature
            if ($school->signature_image) {
                Storage::disk('public')->delete($school->signature_image);
            }
            $data['signature_image'] = $this->uploadSignature($request->file('signature_image'));
        }

        $school->update($data);

        return redirect()->route('admin.schools.index')
            ->with('success', 'School updated successfully.');
    }

    /**
     * Remove the specified school
     */
    public function destroy(School $school)
    {
        // Delete logo if exists
        if ($school->logo) {
            Storage::disk('public')->delete($school->logo);
        }

        // Delete signature if exists
        if ($school->signature_image) {
            Storage::disk('public')->delete($school->signature_image);
        }

        $school->delete();

        return redirect()->route('admin.schools.index')
            ->with('success', 'School deleted successfully. All related data has been removed.');
    }

    /**
     * Show users management for a school
     */
    public function users(School $school)
    {
        $users = $school->users()->orderBy('created_at', 'desc')->get();
        $availableUsers = User::where('role', 'super_admin')
            ->orWhereNull('school_id')
            ->orderBy('name')
            ->get();

        return view('admin.schools.users', compact('school', 'users', 'availableUsers'));
    }

    /**
     * Upload and process school logo
     */
    private function uploadLogo($file): string
    {
        $filename = uniqid() . '_' . time() . '.' . $file->getClientOriginalExtension();
        $path = 'uploads/logos';

        Storage::makeDirectory("public/{$path}");

        $image = Image::read($file);

        // Resize logo to max 400px width, maintain aspect ratio
        if ($image->width() > 400) {
            $image->scale(width: 400);
        }

        $image->save(storage_path("app/public/{$path}/{$filename}"), quality: 90);

        return "{$path}/{$filename}";
    }

    /**
     * Upload and process signature image
     */
    private function uploadSignature($file): string
    {
        $filename = uniqid() . '_' . time() . '.' . $file->getClientOriginalExtension();
        $path = 'uploads/signatures';

        Storage::makeDirectory("public/{$path}");

        $image = Image::read($file);

        // Resize signature to max 300px width
        if ($image->width() > 300) {
            $image->scale(width: 300);
        }

        $image->save(storage_path("app/public/{$path}/{$filename}"), quality: 90);

        return "{$path}/{$filename}";
    }
}
