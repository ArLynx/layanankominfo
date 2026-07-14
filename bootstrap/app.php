<?php

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
         $middleware->alias([
             'role' => \App\Http\Middleware\RoleMiddleware::class,
             '2fa.ensure' => \App\Http\Middleware\EnsureTwoFactorIsEnabled::class,
             '2fa.admin' => \App\Http\Middleware\EnsureTwoFactorForAdmins::class,
             'profile.complete' => \App\Http\Middleware\EnsureProfileIsComplete::class,
             'nocache' => \App\Http\Middleware\PreventBackHistory::class,
         ]);

         $middleware->redirectGuestsTo(function (Request $request) {
             if ($request->is('admin/*') || $request->is('pimpinan/*')) {
                 return route('admin.login');
             }

             return route('login');
         });

         $middleware->redirectUsersTo(function (Request $request) {
             if ($request->is('pimpinan/*') || auth('admin')->user()?->role === 'pimpinan') {
                 return route('pimpinan.dashboard');
             }

             if ($request->is('admin/*')) {
                 return route('admin.dashboard');
             }

             return route('dashboard');
         });
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn(Request $request) => $request->is('api/*'),
        );

    })->create();
