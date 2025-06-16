<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Producto;

class RevisarProductosController extends Controller
{
    public function index()
    {
        $productos = Producto::where('estado', 'pendiente')->latest()->paginate(10);
        return view('admin.revisar-productos.index', compact('productos'));
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
