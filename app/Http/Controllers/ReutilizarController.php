<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\SolicitudReutilizacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications\NuevaSolicitudReutilizacion;

class ReutilizarController extends Controller
{
        public function solicitar(Producto $producto)
        {
            abort_unless($producto->estado === 'aprobado', 403);
            abort_if($producto->user_id === Auth::id(), 403);

            // Verificar si ya existe una solicitud
            $existe = SolicitudReutilizacion::where('producto_id', $producto->id)
                ->where('solicitante_id', Auth::id())
                ->exists();

            if ($existe) {
                return back()->with('info', 'Ya solicitaste reutilizar este producto.');
            }
        
            SolicitudReutilizacion::create([
                'producto_id' => $producto->id,
                'solicitante_id' => Auth::id(),
                'estado' => 'pendiente',
            ]);
        
            // Notificar al dueño
            $producto->user->notify(new NuevaSolicitudReutilizacion(Auth::user(), $producto));
        
            return back()->with('success', 'Solicitud enviada al dueño del producto.');
        }
}
