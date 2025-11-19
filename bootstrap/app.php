<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Register middleware aliases
        $middleware->alias([
            'auth' => \App\Http\Middleware\Authenticate::class,
            'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
            'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
            'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        ]);

        // Configure trusted proxies if behind load balancer/proxy
        $middleware->trustProxies(at: '*');

        // Encrypt cookies
        $middleware->encryptCookies(except: [
            // Add any cookies that shouldn't be encrypted
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
