<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     * 
     */
     public const HOME = '/dashboard';

    public const ADMIN = '/admin/dashboard';
    // public const WELCOME = '/';

    public const WELCOME = '/admin/login-form';

    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
