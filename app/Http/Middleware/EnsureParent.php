<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureParent
{
    /**
     * Handle an incoming request.
     *
     * Ensures the authenticated user has the 'parent' role.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->user() || !$request->user()->isParent()) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Unauthorized. Parent access required.'], 403);
            }

            abort(403, 'Unauthorized. Parent access required.');
        }

        return $next($request);
    }
}
