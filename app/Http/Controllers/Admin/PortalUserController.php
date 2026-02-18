<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Staff;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class PortalUserController extends Controller
{
    /**
     * Display a listing of portal users (staff, student, parent).
     */
    public function index(Request $request)
    {
        $type = $request->get('type', 'all');

        $query = User::where('school_id', session('active_school_id'))
            ->whereIn('role', ['staff', 'student', 'parent']);

        if ($type !== 'all') {
            $query->where('role', $type);
        }

        $users = $query->with(['staff', 'student'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        $stats = [
            'staff' => User::where('school_id', session('active_school_id'))->where('role', 'staff')->count(),
            'student' => User::where('school_id', session('active_school_id'))->where('role', 'student')->count(),
            'parent' => User::where('school_id', session('active_school_id'))->where('role', 'parent')->count(),
        ];

        return view('admin.portal-users.index', compact('users', 'type', 'stats'));
    }

    /**
     * Show the form for creating a new portal user.
     */
    public function create(Request $request)
    {
        $type = $request->get('type', 'staff');

        $staff = [];
        $students = [];

        if ($type === 'staff') {
            // Get staff without user accounts
            $staff = Staff::where('school_id', session('active_school_id'))
                ->whereDoesntHave('user')
                ->orderBy('name')
                ->get();
        } elseif ($type === 'student') {
            // Get students without user accounts
            $students = Student::where('school_id', session('active_school_id'))
                ->whereDoesntHave('user')
                ->orderBy('name')
                ->get();
        } elseif ($type === 'parent') {
            // Get students for parent linking
            $students = Student::where('school_id', session('active_school_id'))
                ->with(['schoolClass', 'schoolSection'])
                ->orderBy('name')
                ->get();
        }

        return view('admin.portal-users.create', compact('type', 'staff', 'students'));
    }

    /**
     * Store a newly created portal user.
     */
    public function store(Request $request)
    {
        $type = $request->input('type');

        $rules = [
            'type' => ['required', Rule::in(['staff', 'student', 'parent'])],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ];

        if ($type === 'staff') {
            $rules['staff_id'] = ['required', 'exists:staff,id'];
        } elseif ($type === 'student') {
            $rules['student_id'] = ['required', 'exists:students,id'];
        } elseif ($type === 'parent') {
            $rules['children'] = ['required', 'array', 'min:1'];
            $rules['children.*'] = ['exists:students,id'];
            $rules['relationships'] = ['required', 'array'];
            $rules['relationships.*'] = [Rule::in(['father', 'mother', 'guardian', 'other'])];
        }

        $validated = $request->validate($rules);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $type,
            'school_id' => session('active_school_id'),
            'staff_id' => $type === 'staff' ? $validated['staff_id'] : null,
            'student_id' => $type === 'student' ? $validated['student_id'] : null,
        ]);

        // Link children for parent users
        if ($type === 'parent' && !empty($validated['children'])) {
            foreach ($validated['children'] as $index => $studentId) {
                $relationship = $validated['relationships'][$index] ?? 'guardian';
                $user->children()->attach($studentId, ['relationship' => $relationship]);
            }
        }

        $typeLabel = ucfirst($type);
        return redirect()->route('admin.portal-users.index', ['type' => $type])
            ->with('success', "{$typeLabel} portal user created successfully.");
    }

    /**
     * Show portal user details.
     */
    public function show(User $portalUser)
    {
        $portalUser->load(['staff', 'student', 'children.schoolClass', 'children.schoolSection']);

        return view('admin.portal-users.show', compact('portalUser'));
    }

    /**
     * Show edit form.
     */
    public function edit(User $portalUser)
    {
        $students = Student::where('school_id', session('active_school_id'))
            ->with(['schoolClass', 'schoolSection'])
            ->orderBy('name')
            ->get();

        $linkedChildren = $portalUser->children()->pluck('students.id')->toArray();
        $relationships = $portalUser->children()->get()->pluck('pivot.relationship', 'id')->toArray();

        return view('admin.portal-users.edit', compact('portalUser', 'students', 'linkedChildren', 'relationships'));
    }

    /**
     * Update portal user.
     */
    public function update(Request $request, User $portalUser)
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($portalUser->id)],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ];

        if ($portalUser->role === 'parent') {
            $rules['children'] = ['nullable', 'array'];
            $rules['children.*'] = ['exists:students,id'];
            $rules['relationships'] = ['nullable', 'array'];
        }

        $validated = $request->validate($rules);

        $portalUser->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
        ]);

        if (!empty($validated['password'])) {
            $portalUser->update(['password' => Hash::make($validated['password'])]);
        }

        // Sync children for parent users
        if ($portalUser->role === 'parent') {
            $syncData = [];
            $children = $validated['children'] ?? [];
            $relationships = $validated['relationships'] ?? [];

            foreach ($children as $index => $studentId) {
                $syncData[$studentId] = ['relationship' => $relationships[$index] ?? 'guardian'];
            }

            $portalUser->children()->sync($syncData);
        }

        return redirect()->route('admin.portal-users.index', ['type' => $portalUser->role])
            ->with('success', 'Portal user updated successfully.');
    }

    /**
     * Delete portal user.
     */
    public function destroy(User $portalUser)
    {
        $type = $portalUser->role;
        $portalUser->delete();

        return redirect()->route('admin.portal-users.index', ['type' => $type])
            ->with('success', 'Portal user deleted successfully.');
    }
}
