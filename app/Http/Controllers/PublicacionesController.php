<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Categoria;
use Illuminate\Http\Request;

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

        return view('publicaciones.index', compact('productos', 'categorias'));
    }
     public function show(Producto $producto)
    {
        // Solo mostrar productos aprobados
        abort_unless($producto->estado === 'aprobado' && !$producto->finalizado, 404);
        $producto->increment('vistas');
        return view('publicaciones.show', compact('producto'));
    }
}
