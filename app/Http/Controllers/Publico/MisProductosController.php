<?php

namespace App\Http\Controllers\Publico;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Categoria;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class MisProductosController extends Controller
{
    public function index()
    {
        $productos = Producto::where('user_id', Auth::id())->latest()->paginate(10);
        return view('publico.productos.index', compact('productos'));
    }

    public function create()
    {
        $categorias = Categoria::all();
        return view('publico.productos.create', compact('categorias'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required',
            'ubicacion' => 'required|string|max:255',
            'imagen' => 'nullable|image|max:2048',
            'categoria_id' => 'required|exists:categorias,id',
        ]);

        $ruta = null;
        if ($request->hasFile('imagen')) {
            $ruta = $request->file('imagen')->store('productos', 'public');
        }

        Producto::create([
            'user_id' => Auth::id(),
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
            'ubicacion' => $request->ubicacion,
            'imagen' => $ruta,
            'categoria_id' => $request->categoria_id,
            'estado' => 'pendiente',
        ]);

        return redirect()->route('mis-productos.index')->with('success', 'Producto publicado y enviado para revisión.');
    }

    public function show(Producto $mis_producto)
    {
        abort_unless($mis_producto->user_id === Auth::id(), 403);
        return view('publico.productos.show', compact('mis_producto'));
    }

    public function edit(Producto $mis_producto)
    {
        abort_unless($mis_producto->user_id === Auth::id(), 403);
        if ($mis_producto->entregado) {
            return redirect()->route('mis-productos.index')->with('error', 'No se puede editar un producto que ya fue entregado.');
        }
        $categorias = Categoria::all();
        return view('publico.productos.edit', compact('mis_producto', 'categorias'));
    }

    public function update(Request $request, Producto $mis_producto)
    {
        abort_unless($mis_producto->user_id === Auth::id(), 403);

        if ($mis_producto->entregado) {
            return redirect()->route('mis-productos.index')->with('error', 'No se puede actualizar un producto entregado.');
        }

        $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required',
            'imagen' => 'nullable|image|max:2048',
            'categoria_id' => 'required|exists:categorias,id',
        ]);

        if ($request->hasFile('imagen')) {
            if ($mis_producto->imagen) {
                Storage::disk('public')->delete($mis_producto->imagen);
            }
            $mis_producto->imagen = $request->file('imagen')->store('productos', 'public');
        }

        $mis_producto->update([
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
            'categoria_id' => $request->categoria_id,
        ]);

        return redirect()->route('mis-productos.index')->with('success', 'Producto actualizado.');
    }

    public function destroy(Producto $mis_producto)
    {
        abort_unless($mis_producto->user_id === Auth::id(), 403);

        DB::transaction(function () use ($mis_producto) {
            // Eliminar imagen si existe
            if ($mis_producto->imagen) {
                Storage::disk('public')->delete($mis_producto->imagen);
            }

            // Eliminar conversaciones relacionadas al producto
            $mis_producto->conversaciones()->delete();

            // Eliminar el producto
            $mis_producto->delete();
        });

            return redirect()->route('mis-productos.index')->with('success', 'Producto eliminado.');
    }

    public function marcarComoEntregado(Producto $producto)
    {
        // Verificamos que el producto sea del usuario autenticado
        if ($producto->user_id !== Auth::id()) {
            abort(403);
        }

        if ($producto->estado !== 'aprobado') {
        return redirect()->route('mis-productos.index')->with('error', 'Solo puedes marcar productos aprobados como entregados.');
        }

        $tieneSolicitudAceptada = $producto->solicitudes()
        ->where('estado', 'aceptado')
        ->exists();

        if (!$tieneSolicitudAceptada) {
         return redirect()->route('mis-productos.index')->with('error', 'Este producto debe tener una solicitud aceptada para poder marcarlo como entregado.');
        }

        $producto->entregado = true;
        $producto->save();

        return redirect()->route('mis-productos.index')->with('success', 'Producto marcado como entregado.');
    }

    public function confirmarRecepcion(Producto $producto)
    {
        $solicitud = $producto->solicitudes()
            ->where('solicitante_id', Auth::id())
            ->where('estado', 'aceptado')
            ->first();

        if (!$solicitud || !$producto->entregado) {
            abort(403);
        }

        $producto->confirmado_por_receptor = true;
        $producto->save();

        return redirect()->route('publicaciones.index')->with('success', 'Has confirmado la recepción del producto.');
    }

}
