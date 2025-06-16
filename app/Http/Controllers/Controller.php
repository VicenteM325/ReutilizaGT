<?php

namespace App\Http\Controllers;
use App\Models\Producto;

abstract class Controller
{
    public function show(Producto $producto)
    {
    $producto->increment('vistas');

    return view('publicaciones.show', compact('producto'));
    }
}
