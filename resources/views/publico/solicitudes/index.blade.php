@extends('adminlte::page')

@section('title', 'Solicitudes de Reutilización')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1><i class="fas fa-recycle mr-2"></i>Solicitudes Recibidas</h1>
        <a href="{{ url()->previous() }}" class="btn btn-sm btn-outline-secondary">
            <i class="fas fa-arrow-left mr-1"></i> Volver
        </a>
    </div>
@stop

@section('content')
<div class="container-fluid">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
                </div>
                @if(session('chat_route'))
                    <a href="{{ session('chat_route') }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-comments mr-1"></i> Ir al chat
                    </a>
                @endif
                <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>
        </div>
    @endif

    <div class="card">
        <div class="card-header bg-light">
            <h3 class="card-title mb-0"><i class="fas fa-list mr-2"></i>Listado de solicitudes</h3>
        </div>

        <div class="card-body p-0">
            <table class="table table-hover">
                <thead class="bg-gray-100">
                    <tr>
                        <th>Producto</th>
                        <th>Solicitante</th>
                        <th>Estado</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($solicitudes as $solicitud)
                        <tr>
                            <td>{{ $solicitud->producto->titulo }}</td>
                            <td>{{ $solicitud->solicitante->name }}</td>
                            <td>
                                <span class="badge 
                                    @if($solicitud->estado === 'pendiente') badge-warning
                                    @elseif($solicitud->estado === 'aceptada') badge-success
                                    @else badge-danger
                                    @endif">
                                    {{ ucfirst($solicitud->estado) }}
                                </span>
                            </td>
                            <td class="text-center">
                                @if($solicitud->estado === 'pendiente')
                                    <div class="btn-group btn-group-sm" role="group">
                                        <form action="{{ route('solicitudes.aceptar', $solicitud->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-success" title="Aceptar">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </form>
                                        <form action="{{ route('solicitudes.rechazar', $solicitud->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-danger" title="Rechazar">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </form>
                                    </div>
                                @else
                                    <span class="text-muted small">Respondida</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-4 text-muted">
                                <i class="fas fa-inbox fa-2x mb-2"></i><br>
                                No hay solicitudes pendientes
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('css')
<style>
    .table {
        margin-bottom: 0;
    }
    .table-hover tbody tr:hover {
        background-color: rgba(0,0,0,.02);
    }
    .bg-gray-100 {
        background-color: #f8f9fa;
    }
    .badge-warning {
        background-color: #ffc107;
        color: #212529;
    }
    .btn-group-sm > .btn {
        padding: 0.25rem 0.5rem;
    }
</style>
@endsection

@section('js')
<script>
    $(document).ready(function() {
        setTimeout(function() {
            $('.alert').alert('close');
        }, 5000);
    });
</script>
@endsection