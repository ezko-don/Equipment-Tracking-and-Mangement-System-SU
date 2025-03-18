<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__)) // ✅ Fixed dirname(__DIR__)
    ->withRouting(
        web: __DIR__.'/../routes/web.php',  // ✅ Fixed path issue
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // ✅ Register middleware correctly
        $middleware->web([
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class, // ✅ Laravel 11 CSRF Middleware
            \App\Http\Middleware\IsAdmin::class, // ✅ Custom IsAdmin middleware
        ]);

    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();