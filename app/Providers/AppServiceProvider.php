<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::define('admin', fn($user) => $user->hasRole('admin'));
        Gate::define('moderador', fn($user) => $user->hasRole('moderador'));
        Gate::define('publico', fn($user) => $user->hasRole('publico'));
    }
}
