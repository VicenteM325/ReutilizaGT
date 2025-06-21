<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Producto;
use Spatie\Permission\Models\Role;

class ReporteController extends Controller
{
    public function index()
    {
        $tipo = null;
        return view('admin.reportes.index', compact('tipo'));
    }

    public function filtrar(Request $request)
    {
        $tipo = $request->input('tipo');

        switch ($tipo) {
            case 'aprobado':
                $resultados = User::role('publico')
                    ->withCount(['productos as aprobado' => function ($query) {
                        $query->where('estado', 'aprobado');
                    }])
                    ->orderByDesc('aprobado')
                    ->take(10)
                    ->get();
                $titulo = 'Usuarios con más publicaciones aprobadas';
                break;

            case 'finalizado':
                $resultados = User::role('publico')
                    ->withCount(['productos as finalizado' => function ($query) {
                        $query->where('finalizado', true);
                    }])
                    ->orderByDesc('finalizado')
                    ->take(10)
                    ->get();
                $titulo = 'Usuarios con más publicaciones finalizadas';
                break;

            case 'rechazado':
                $resultados = User::role('publico')
                    ->withCount(['productos as rechazado' => function ($query) {
                        $query->where('estado', 'rechazado');
                    }])
                    ->orderByDesc('rechazado')
                    ->take(10)
                    ->get();
                $titulo = 'Usuarios con más publicaciones rechazadas';
                break;

            case 'pendiente':
                $resultados = User::role('publico')
                    ->withCount(['productos as pendiente' => function ($query) {
                        $query->where('estado', 'pendiente');
                    }])
                    ->orderByDesc('pendiente')
                    ->take(10)
                    ->get();
                $titulo = 'Usuarios con más publicaciones pendientes';
                break;

            default:
                return redirect()->route('admin.reportes.index')->with('error', 'Filtro no válido');
        }

        return view('admin.reportes.index', compact('resultados', 'titulo', 'tipo'));
    }

}
