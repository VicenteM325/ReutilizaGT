<?php

namespace App\Http\Controllers\Publico;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SolicitudReutilizacion;
use Illuminate\Support\Facades\Auth;
use App\Models\Conversacion;


class SolicitudesRecibidasController extends Controller
{
    public function index()
    {
        $solicitudes = SolicitudReutilizacion::whereHas('producto', function ($q) {
            $q->where('user_id', Auth::id());
        })->with('producto', 'solicitante')->get();

        return view('publico.solicitudes.index', compact('solicitudes'));
    }

    public function aceptar($id)
    {
    $solicitud = SolicitudReutilizacion::with('producto', 'solicitante')->findOrFail($id);
    $solicitud->estado = 'aceptado';
    $solicitud->save();

    $conversacion = Conversacion::firstOrCreate([
        'producto_id' => $solicitud->producto_id,
        'user1_id' => $solicitud->producto->user_id,
        'user2_id' => $solicitud->solicitante_id,
    ]);

    return redirect()->route('solicitudes.index')
        ->with('success', 'Solicitud aceptada correctamente.')
        ->with('chat_route', route('chat.mostrar', $conversacion->id));
    }

    public function rechazar($id)
    {
        $solicitud = SolicitudReutilizacion::findOrFail($id);
        $solicitud->estado = 'rechazado';
        $solicitud->save();

        return redirect()->route('solicitudes.index')->with('success', 'Solicitud rechazada');
    }
}
