<?php

namespace App\Http\Controllers\Moderador;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\User;
use App\Models\Categoria;

class ModeradorDashboardController extends Controller
{
    public function index()
    {
        return view('moderador.dashboard', [
            'pendientes' => Producto::where('estado', 'pendiente')->count(),
            'aprobados' => Producto::where('estado', 'aprobado')->count(),
            'rechazados' => Producto::where('estado', 'rechazado')->count(),
            'usuarios' => User::count(),
            'categorias' => Categoria::count(),
        ]);
    }
}
