<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\View;
use App\Models\SolicitudReutilizacion;
use Illuminate\Support\Facades\Auth;
use JeroenNoten\LaravelAdminLte\Events\BuildingMenu;
use App\Models\Mensaje;
use Illuminate\Pagination\Paginator;

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
        Paginator::useBootstrap();

        $this->app['events']->listen(BuildingMenu::class, function (BuildingMenu $event) {
            if (Auth::check() && Auth::user()->hasRole('publico')) {

                $pendientes = SolicitudReutilizacion::whereHas('producto', function ($q) {
                    $q->where('user_id', Auth::id());
                })->where('estado', 'pendiente')->count();
            
                $event->menu->add([
                    'text' => 'Solicitudes',
                    'url'  => 'publico/solicitudes',
                    'icon' => 'fas fa-inbox',
                    'can'  => 'publico',
                    'label' => $pendientes > 0 ? (string) $pendientes : null,
                    'label_color' => 'danger',
                ]);
            
                $noLeidos = Mensaje::where('para_id', Auth::id())
                    ->where('leido', false)
                    ->count();
            
                $event->menu->add([
                    'text' => 'Mi Chat',
                    'url' => 'chat',
                    'icon' => 'fas fa-comments',
                    'can' => 'publico',
                    'label' => $noLeidos > 0 ? (string) $noLeidos : null,
                    'label_color' => 'danger',
                ]);
            }
        });
    }
}
