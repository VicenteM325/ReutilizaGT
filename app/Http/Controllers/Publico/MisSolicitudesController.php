<?php

namespace App\Http\Controllers\Publico;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\SolicitudReutilizacion;
use App\Models\Producto;

class MisSolicitudesController extends Controller
{
    public function index()
    {
        $solicitudes = SolicitudReutilizacion::with('producto')
            ->where('solicitante_id', Auth::id())
            ->get();

        return view('publico.solicitudes.mis_solicitudes', compact('solicitudes'));
    }

    public function confirmar(Producto $producto)
    {
        $solicitud = $producto->solicitudes()
            ->where('solicitante_id', Auth::id())
            ->where('estado', 'aceptado')
            ->first();

        if (!$solicitud || !$producto->entregado) {
            abort(403);
        }

        $producto->confirmado_por_receptor = true;
        if($producto->entregado){
            $producto->finalizado = true;
        }
        $producto->save();

        return redirect()->route('mis-solicitudes.index')->with('success', 'Has confirmado la recepción del producto.');
    }
}
