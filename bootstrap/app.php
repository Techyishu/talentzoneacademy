<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Register middleware aliases
        $middleware->alias([
            'super_admin' => \App\Http\Middleware\EnsureSuperAdmin::class,
            'school_admin' => \App\Http\Middleware\EnsureSchoolAdmin::class,
            'set_school' => \App\Http\Middleware\SetSchoolContext::class,
            'staff' => \App\Http\Middleware\EnsureStaff::class,
            'student' => \App\Http\Middleware\EnsureStudent::class,
            'parent' => \App\Http\Middleware\EnsureParent::class,
        ]);

        // Apply SetSchoolContext to web middleware group
        $middleware->web(append: [
            \App\Http\Middleware\SetSchoolContext::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
