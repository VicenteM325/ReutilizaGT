<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Categoria;

class CategoriasController extends Controller
{
    public function index()
    {
        $categorias = Categoria::paginate(10);
        return view('admin.categorias.index', compact('categorias'));
    }

    public function create()
    {
        return view('admin.categorias.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string|max:255',
        ]);

        Categoria::create($request->only('nombre', 'descripcion'));

        return redirect()->route('admin.categorias.index')->with('success', 'Categoría creada.');
    }

    public function edit(Categoria $categoria)
    {
        return view('admin.categorias.edit', compact('categoria'));
    }

    public function update(Request $request, Categoria $categoria)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string|max:255',
        ]);

        $categoria->update($request->only('nombre', 'descripcion'));

        return redirect()->route('admin.categorias.index')->with('success', 'Categoría actualizada.');
    }

    public function destroy(Categoria $categoria)
    {
        $categoria->delete();
        return redirect()->route('admin.categorias.index')->with('success', 'Categoría eliminada.');
    }
}
