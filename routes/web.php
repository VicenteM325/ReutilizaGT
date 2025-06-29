<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Publico\MisProductosController;
use App\Http\Controllers\Admin\UsuariosController;
use App\Http\Controllers\Admin\RevisarProductosController;
use App\Http\Controllers\Admin\ReporteController;
use App\Http\Controllers\PublicacionesController;
use App\Http\Controllers\ReutilizarController;
use App\Http\Controllers\NotificacionController;
use App\Http\Controllers\Publico\SolicitudesRecibidasController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\Publico\MisSolicitudesController;
use App\Http\Controllers\Moderador\ModeradorDashboardController;
use App\Http\Controllers\Admin\CategoriasController;



Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
]);

Route::get('/dashboard', function () {
    $user = Auth::user();

    if ($user->hasRole('admin')) {
        return redirect()->route('admin.dashboard');
    }

    if ($user->hasRole('moderador')) {
        return redirect()->route('moderador.dashboard');
    }

    if ($user->hasRole('publico')) {
        return redirect()->route('publicaciones.index');
    }

    abort(403); 
})->name('dashboard');

    //Administrar roles de usuarios admin
    Route::middleware(['role:admin|moderador'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function() {
        return view('admin.dashboard');
    })->name('dashboard');

    Route::resource('usuarios', UsuariosController::class);
    Route::resource('categorias', CategoriasController::class);
    });

    //Aprobacion de publicaciones
    Route::middleware(['role:admin|moderador'])->prefix('moderacion')->name('moderacion.')->group(function () {
    Route::get('productos', [RevisarProductosController::class, 'index'])->name('productos.index');
    Route::put('productos/{producto}/aprobar', [RevisarProductosController::class, 'aprobar'])->name('productos.aprobar');
    Route::patch('productos/{producto}/rechazar', [RevisarProductosController::class, 'rechazar'])->name('productos.rechazar');
    });

    //Dashboard Moderador
    Route::middleware(['auth', 'role:moderador'])->prefix('moderador')->name('moderador.')->group(function () {
    Route::get('/dashboard', [ModeradorDashboardController::class, 'index'])->name('dashboard');
    });

    //Usuario Publico
    Route::middleware(['role:publico'])->prefix('publico')->group(function () {
        Route::get('/dashboard', function () {
        return redirect()->route('publicaciones.index');
        })->name('publico.dashboard');
    Route::resource('/mis-productos', MisProductosController::class)->names('mis-productos');
    Route::put('/mis-productos/{producto}/entregar', [MisProductosController::class, 'marcarComoEntregado'])->name('mis-productos.entregar');
    });
    //Solicitudes enviadas
    Route::middleware(['auth', 'role:publico'])->prefix('publico')->group(function () {
    Route::get('/mis-solicitudes', [MisSolicitudesController::class, 'index'])->name('mis-solicitudes.index');
    Route::put('/mis-solicitudes/{producto}/confirmar', [MisSolicitudesController::class, 'confirmar'])->name('mis-solicitudes.confirmar');
    });

    //Solicitudes Recibidas
    Route::middleware(['role:publico'])->prefix('publico')->group(function () {
    Route::get('/solicitudes', [SolicitudesRecibidasController::class, 'index'])->name('publico.solicitudes');
    });
    
    //Publicaciones
    Route::get('/publicaciones', [PublicacionesController::class, 'index'])->name('publicaciones.index');
    Route::get('/publicaciones/{producto}', [PublicacionesController::class, 'show'])->name('publicaciones.show');
    
    //Reutilizar
    Route::middleware(['auth'])->post('/productos/{producto}/reutilizar', [ReutilizarController::class, 'solicitar'])->name('productos.reutilizar');
    
    //Chat
    Route::middleware(['auth', 'role:publico'])->prefix('publico')->group(function () {
    Route::get('solicitudes', [SolicitudesRecibidasController::class, 'index'])->name('solicitudes.index');
    Route::put('solicitudes/{id}/aceptar', [SolicitudesRecibidasController::class, 'aceptar'])->name('solicitudes.aceptar');
    Route::put('solicitudes/{id}/rechazar', [SolicitudesRecibidasController::class, 'rechazar'])->name('solicitudes.rechazar');
    });

    //RUTA para mostrar conversación por ID (chat entre 2 usuarios)
    Route::middleware(['auth'])->group(function () {
    Route::get('/conversaciones/{id}', [ChatController::class, 'mostrar'])->name('chat.mostrar');
    Route::post('/conversaciones/{id}/mensaje', [ChatController::class, 'enviar'])->name('chat.enviar');
    });

    //RUTA para listar conversaciones del usuario logueado
    Route::middleware(['auth', 'verified'])->get('/chat', [ChatController::class, 'listarConversaciones'])->name('chat.index');

    //Notificaciones
    Route::middleware(['auth', 'role:publico'])->group(function () {
    Route::get('usuario/notificaciones', [NotificacionController::class, 'index'])
        ->name('usuario.notificaciones');

    Route::post('usuario/notificaciones/leidas', [NotificacionController::class, 'marcarTodasLeidas'])
    ->name('usuario.notificaciones.leer-todas');
    });

    //Reportes
    Route::middleware(['auth', 'role:admin|moderador'])->prefix('admin/reportes')->group(function () {
    Route::get('/', [ReporteController::class, 'index'])->name('admin.reportes.index');
    Route::post('/filtrar', [ReporteController::class, 'filtrar'])->name('admin.reportes.filtrar');
    });