<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class PasswordController extends Controller
{
    /**
     * Show the change own password form.
     */
    public function edit()
    {
        return view('admin.password.edit');
    }

    /**
     * Update the authenticated user's password.
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', Password::defaults(), 'confirmed'],
        ]);

        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        return back()->with('success', 'Password changed successfully.');
    }

    /**
     * Show the reset password form for a school admin (super admin only).
     */
    public function editUser(User $user)
    {
        abort_unless($user->role === 'school_admin', 403);

        return view('admin.password.edit-user', compact('user'));
    }

    /**
     * Reset a school admin's password (super admin only).
     */
    public function updateUser(Request $request, User $user)
    {
        abort_unless($user->role === 'school_admin', 403);

        $validated = $request->validate([
            'password' => ['required', Password::defaults(), 'confirmed'],
        ]);

        $user->update([
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()->route('admin.schools.show', $user->school_id)
            ->with('success', "Password reset successfully for {$user->name}.");
    }
}
