@extends('adminlte::page')

@section('content')
<div class="container">
    <h2>Mis Solicitudes</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($solicitudes->isEmpty())
        <p>No has solicitado ningún producto todavía.</p>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Estado</th>
                    <th>Entrega</th>
                    <th>Confirmar</th>
                </tr>
            </thead>
            <tbody>
                @foreach($solicitudes as $solicitud)
                    <tr>
                        <td>{{ $solicitud->producto->titulo }}</td>
                        <td>
                            <span class="badge 
                                {{ $solicitud->estado === 'pendiente' ? 'bg-warning' : ($solicitud->estado === 'aceptado' ? 'bg-success' : 'bg-danger') }}">
                                {{ ucfirst($solicitud->estado) }}
                            </span>
                        </td>
                        <td>
                            @if($solicitud->producto->entregado)
                                <span class="text-success">Marcado como entregado</span>
                            @else
                                <span class="text-muted">Pendiente</span>
                            @endif
                        </td>
                        <td>
                            @if($solicitud->producto->entregado && !$solicitud->producto->confirmado_por_receptor)
                                <form method="POST" action="{{ route('mis-solicitudes.confirmar', $solicitud->producto->id) }}">
                                    @csrf
                                    @method('PUT')
                                    <button class="btn btn-sm btn-primary">Confirmar recepción</button>
                                </form>
                            @elseif($solicitud->producto->confirmado_por_receptor)
                                <span class="text-success">Recepción confirmada</span>
                            @else
                                <span class="text-muted">No disponible</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
