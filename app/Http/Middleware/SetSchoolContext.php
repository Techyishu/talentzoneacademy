<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetSchoolContext
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check()) {
            $user = auth()->user();

            // For school admins, set their school as active if not already set
            if ($user->isSchoolAdmin() && !session('active_school_id')) {
                session(['active_school_id' => $user->school_id]);
            }

            // For super admins, if no active school is set, set the first school
            if ($user->isSuperAdmin() && !session('active_school_id')) {
                $firstSchool = \App\Models\School::first();
                if ($firstSchool) {
                    session(['active_school_id' => $firstSchool->id]);
                }
            }

            // Set active academic session if not already set
            if (session('active_school_id') && !session('active_session_id')) {
                $currentSession = \App\Models\AcademicSession::where('school_id', session('active_school_id'))
                    ->where('is_current', true)
                    ->first();

                if ($currentSession) {
                    session(['active_session_id' => $currentSession->id]);
                }
            }
        }

        return $next($request);
    }
}
