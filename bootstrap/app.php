<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Exceptions\ThrottleRequestsException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {

        $middleware->redirectGuestsTo(fn() => route('login'));

        // ✅ بيحل مشكلة "Route [verification.notice] not found"
        // بيعمل redirect لنظام OTP بتاعنا بدل Laravel الافتراضي
        $middleware->redirectUsersTo(fn() => route('verification.email'));

        $middleware->validateCsrfTokens(except: [
            'kashier/webhook',
        ]);

        $middleware->alias([
            'verified' => \App\Http\Middleware\EnsureEmailIsVerified::class,
            'two_factor' => \App\Http\Middleware\RequireTwoFactor::class,

        ]);

    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (ThrottleRequestsException $e) {
            return response()->view('errors.429', [
                'message' => 'لقد قمت بمحاولات كثيرة جداً. يرجى الانتظار دقيقة قبل المحاولة مرة أخرى.'
            ], 429);
        });
    })->create();
