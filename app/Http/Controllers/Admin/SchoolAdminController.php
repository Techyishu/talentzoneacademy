<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\School;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class SchoolAdminController extends Controller
{
    /**
     * Show the form for creating a new school admin.
     */
    public function create(School $school)
    {
        return view('admin.schools.create-admin', compact('school'));
    }

    /**
     * Store a new school admin user.
     */
    public function store(Request $request, School $school)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', Password::defaults(), 'confirmed'],
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'school_admin',
            'school_id' => $school->id,
        ]);

        return redirect()->route('admin.schools.show', $school)
            ->with('success', "School admin account created successfully for {$school->name}.");
    }
}
