<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificacionController extends Controller
{
    public function index(Request $request)
    {
        $notificaciones = $request->user()->notifications;
        return view('publico.notificaciones.index', compact('notificaciones'));
    }

    public function marcarTodasLeidas(Request $request)
    {
        $request->user()->unreadNotifications->markAsRead();
        return back()->with('success', 'Todas las notificaciones fueron marcadas como leídas.');
    }
}
