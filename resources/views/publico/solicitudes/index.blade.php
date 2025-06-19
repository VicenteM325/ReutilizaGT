@extends('adminlte::page')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <h1>Solicitudes de Reutilización Recibidas</h1>
    </div>
</section>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Listado de solicitudes</h3>
            </div>

            <div class="card-body">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Solicitante</th>
                            <th>Estado</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($solicitudes as $solicitud)
                            <tr>
                                <td>{{ $solicitud->producto->titulo }}</td>
                                <td>{{ $solicitud->solicitante->name }}</td>
                                <td>
                                    <span class="badge 
                                        {{ $solicitud->estado === 'pendiente' ? 'bg-warning' : ($solicitud->estado === 'aceptada' ? 'bg-success' : 'bg-danger') }}">
                                        {{ ucfirst($solicitud->estado) }}
                                    </span>
                                </td>
                                <td>
                                    @if($solicitud->estado === 'pendiente')
                                        <form action="{{ route('solicitudes.aceptar', $solicitud->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('PUT')
                                            <button class="btn btn-success btn-sm">Aceptar</button>
                                        </form>
                                        <form action="{{ route('solicitudes.rechazar', $solicitud->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('PUT')
                                            <button class="btn btn-danger btn-sm">Rechazar</button>
                                        </form>
                                    @else
                                        <span class="text-muted">Ya respondida</span>
                                    @endif
                                    @if(session('success'))
                                    <div class="alert alert-success d-flex justify-content-between align-items-center">
                                        <span>{{ session('success') }}</span>
                                        @if(session('chat_route'))
                                            <a href="{{ session('chat_route') }}" class="btn btn-primary btn-sm">Ir al chat</a>
                                        @endif
                                    </div>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">No tienes solicitudes aún.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</section>
@endsection
