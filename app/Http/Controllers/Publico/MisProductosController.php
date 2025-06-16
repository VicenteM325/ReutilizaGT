<?php

namespace App\Http\Controllers\Publico;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Categoria;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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
        $categorias = Categoria::all();
        return view('publico.productos.edit', compact('mis_producto', 'categorias'));
    }

    public function update(Request $request, Producto $mis_producto)
    {
        abort_unless($mis_producto->user_id === Auth::id(), 403);

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
        if ($mis_producto->imagen) {
            Storage::disk('public')->delete($mis_producto->imagen);
        }
        $mis_producto->delete();
        return redirect()->route('mis-productos.index')->with('success', 'Producto eliminado.');
    }
}
