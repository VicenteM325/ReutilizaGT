<?php

namespace App\Http\Controllers;

use App\Models\Mensaje;
use App\Models\Producto;
use App\Models\SolicitudReutilizacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Conversacion;
use App\Models\User;

class ChatController extends Controller
{
    public function mostrar($id)
    {
        $conversacion = Conversacion::with('mensajes')->findOrFail($id);

        // Seguridad: verificar que el usuario pertenezca a la conversación
        if (!in_array(Auth::id(), [$conversacion->user1_id, $conversacion->user2_id])) {
            abort(403);
        }

        return view('chat.mostrar', compact('conversacion'));
    }

    public function enviar(Request $request, $id)
    {
        $conversacion = Conversacion::findOrFail($id);

        if (!in_array(Auth::id(), [$conversacion->user1_id, $conversacion->user2_id])) {
            abort(403);
        }

            Mensaje::create([
            'conversacion_id' => $conversacion->id,
            'de_id' => Auth::id(),
            'para_id' => Auth::id() === $conversacion->user1_id ? $conversacion->user2_id : $conversacion->user1_id,
            'mensaje' => $request->input('mensaje'),
            ]);

        return redirect()->route('chat.mostrar', $id);
    }
    public function listarConversaciones()
    {
    $userId = Auth::id();
    $conversaciones = Conversacion::with(['usuario1', 'usuario2', 'mensajes'])
        ->where('user1_id', $userId)
        ->orWhere('user2_id', $userId)
        ->get();

    return view('chat.index', compact('conversaciones'));
    }

}
