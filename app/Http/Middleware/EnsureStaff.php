<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureStaff
{
    /**
     * Handle an incoming request.
     *
     * Ensures the authenticated user has the 'staff' role.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->user() || !$request->user()->isStaff()) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Unauthorized. Staff access required.'], 403);
            }

            abort(403, 'Unauthorized. Staff access required.');
        }

        return $next($request);
    }
}
