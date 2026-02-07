<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureSchoolAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is authenticated
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();

        // Super admins can access all areas
        if ($user->isSuperAdmin()) {
            return $next($request);
        }

        // School admins must have an active school context
        if ($user->isSchoolAdmin()) {
            if (!session('active_school_id') || session('active_school_id') !== $user->school_id) {
                // Set their school as active
                session(['active_school_id' => $user->school_id]);
            }
            return $next($request);
        }

        abort(403, 'Unauthorized access.');
    }
}
