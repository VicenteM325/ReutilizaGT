<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Publico\MisProductosController;

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
        return redirect()->route('publico.dashboard');
    }

    abort(403); 
})->name('dashboard');

    Route::middleware(['role:publico'])->prefix('publico')->group(function () {
    Route::get('/dashboard', function () {
        return view('publico.dashboard');
    })->name('publico.dashboard');
    Route::resource('/mis-productos', MisProductosController::class)->names('mis-productos');
    });
    
