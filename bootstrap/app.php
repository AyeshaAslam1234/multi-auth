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
       
        //  Create a middleware group called "admin.web"
        $middleware->group('admin.web', [
            \App\Http\Middleware\AdminSession::class, // sets admin cookie/session
            \Illuminate\Cookie\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ]);

        //  Aliases
        $middleware->alias([
            'admin' => \App\Http\Middleware\Admin::class,
            'guest.admin' => \App\Http\Middleware\RedirectIfAdminAuthenticated::class,
            'admin.redirectIfAuthenticated' => \App\Http\Middleware\RedirectIfAdminAuthenticated::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
