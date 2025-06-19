<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PublicacionesController extends Controller
{
     public function index(Request $request)
    {
        $categorias = Categoria::all();

        $productos = Producto::aprobados()
            ->porCategoria($request->categoria_id)
            ->buscar($request->q)
            ->ordenar($request->orden)
            ->paginate(12)
            ->withQueryString();

        $contribuidorDelMes = Producto::where('estado', 'aprobado')
            ->where('created_at', '>=', Carbon::now()->subDays(30))
            ->selectRaw('user_id, COUNT(*) as total')
            ->groupBy('user_id')
            ->orderByDesc('total')
            ->with('user') 
            ->first();

        return view('publicaciones.index', compact('productos', 'categorias', 'contribuidorDelMes'));
    }
     public function show(Producto $producto)
    {
        // Solo mostrar productos aprobados
        abort_unless($producto->estado === 'aprobado' && !$producto->finalizado, 404);
        $producto->increment('vistas');
        return view('publicaciones.show', compact('producto'));
    }
}
