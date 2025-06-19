<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\View;
use App\Models\SolicitudReutilizacion;
use Illuminate\Support\Facades\Auth;
use JeroenNoten\LaravelAdminLte\Events\BuildingMenu;
use App\Models\Mensaje;

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

        $this->app['events']->listen(BuildingMenu::class, function (BuildingMenu $event) {
            
        // Solo para usuarios autenticados con rol 'publico'
        if (Auth::check() && Auth::user()->hasRole('publico')) {
            $pendientes = SolicitudReutilizacion::whereHas('producto', function ($q) {
                $q->where('user_id', Auth::id());
            })->where('estado', 'pendiente')->count();

            if ($pendientes > 0) {
                // Buscar el item 'Solicitudes' y agregar el label dinámico
                $event->menu->addAfter('mis-productos', [
                    'text' => 'Solicitudes',
                    'url'  => 'publico/solicitudes',
                    'icon' => 'fas fa-box',
                    'label' => (string) $pendientes,
                    'label_color' => 'danger',
                ]);
            }

           
        }
        });
    }
}
