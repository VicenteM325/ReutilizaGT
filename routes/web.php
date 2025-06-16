<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Publico\MisProductosController;
use App\Http\Controllers\Admin\UsuariosController;
use App\Http\Controllers\Admin\RevisarProductosController;
use App\Http\Controllers\PublicacionesController;
use App\Http\Controllers\ReutilizarController;
use App\Http\Controllers\Publico\SolicitudesRecibidasController;
use App\Http\Controllers\ChatController;


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

    //Administrar roles de usuarios admin y moderador
    Route::middleware(['role:admin|moderador'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function() {
        return view('admin.dashboard');
    })->name('dashboard');

    Route::resource('usuarios', UsuariosController::class);
    });

    //Aprobacion de publicaciones
    Route::middleware(['role:admin|moderador'])->prefix('moderacion')->name('moderacion.')->group(function () {
    Route::get('productos', [RevisarProductosController::class, 'index'])->name('productos.index');
    Route::put('productos/{producto}/aprobar', [RevisarProductosController::class, 'aprobar'])->name('productos.aprobar');
    Route::put('productos/{producto}/rechazar', [RevisarProductosController::class, 'rechazar'])->name('productos.rechazar');
    });

    //Usuario Publico
    Route::middleware(['role:publico'])->prefix('publico')->group(function () {
        Route::get('/dashboard', function () {
        return redirect()->route('publicaciones.index');
        })->name('publico.dashboard');
    Route::resource('/mis-productos', MisProductosController::class)->names('mis-productos');
    });
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

    Route::middleware(['auth'])->group(function () {
    Route::get('chat/{producto}', [ChatController::class, 'show'])->name('chat.show');
    Route::post('chat/{producto}', [ChatController::class, 'enviar'])->name('chat.enviar');
    });
    Route::middleware(['auth', 'role:publico'])->prefix('publico')->group(function () {
    Route::get('chat', [ChatController::class, 'index'])->name('chat.index');
    });
    //Rutas para ver los mensajes
    Route::middleware(['auth'])->group(function () {
    Route::get('conversaciones/{id}', [ChatController::class, 'mostrar'])->name('chat.mostrar');
    Route::post('conversaciones/{id}/mensaje', [ChatController::class, 'enviar'])->name('chat.enviar');
    });
    //Ruta para listar conversaciones
    Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/chat', [ChatController::class, 'listarConversaciones'])->name('chat.index');
    Route::get('/chat/{id}', [ChatController::class, 'mostrar'])->name('chat.mostrar');
    Route::post('/chat/{id}', [ChatController::class, 'enviar'])->name('chat.enviar');
    });