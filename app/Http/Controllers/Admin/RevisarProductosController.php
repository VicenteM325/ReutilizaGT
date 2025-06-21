<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Producto;
use App\Notifications\ProductoRechazado;

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

    public function rechazar(Request $request, Producto $producto)
    {
        $request->validate([
        'motivo' => 'required|string|max:500',
        ]);

        $motivo = $request->motivo;
        $producto->update(['estado' => 'rechazado']);
        $producto->user->notify(new ProductoRechazado($producto, $motivo));
        
        return back()->with('error', 'Producto rechazado y notificado al dueño');
    }
}
