<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Producto;

class RevisarProductosController extends Controller
{
    public function index(Request $request)
    {
        $estado = $request->estado;

        $query = Producto::query();

        if ($estado) {
            $query->where('estado', $estado);
        }

        $productos = $query->latest()->paginate(10);

        return view('admin.revisar-productos.index', compact('productos', 'estado'));
    }

    public function aprobar(Producto $producto)
    {
        $producto->update(['estado' => 'aprobado']);
        return back()->with('success', 'Producto aprobado');
    }

    public function rechazar(Producto $producto)
    {
        $producto->update(['estado' => 'rechazado']);
        return back()->with('error', 'Producto rechazado');
    }
}
