<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureStudent
{
    /**
     * Handle an incoming request.
     *
     * Ensures the authenticated user has the 'student' role.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->user() || !$request->user()->isStudent()) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Unauthorized. Student access required.'], 403);
            }

            abort(403, 'Unauthorized. Student access required.');
        }

        return $next($request);
    }
}
