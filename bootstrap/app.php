<?php

use App\Http\Middleware\AdminLog;
use App\Http\Middleware\AdminLogged;
use App\Http\Middleware\AuthenticatedUser;
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
       $middleware->alias([
            'admin.logged_in'=> AdminLog::class,
            'admin.logged_out'=> AdminLogged::class,
            'check.user'=>AuthenticatedUser::class,
        ]);
        $middleware->validateCsrfTokens(except: [
            // '/dashboard/payment/*',
            // 'api/webhook/payment'
			// 'http://example.com/foo/bar',
			// 'http://example.com/foo/*',
		]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
