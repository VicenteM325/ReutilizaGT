@extends('adminlte::page')

@section('title', 'Notificaciones')

@section('content_header')
    <h1><i class="fas fa-bell mr-2"></i>Notificaciones</h1>
@endsection

@section('content')
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
    @endif

    @if (auth()->user()->unreadNotifications->count())
        <form action="{{ route('usuario.notificaciones.leer-todas') }}" method="POST" class="mb-3">
            @csrf
            <button class="btn btn-outline-secondary btn-sm">
                <i class="fas fa-check-double mr-1"></i> Marcar todas como leídas
            </button>
        </form>

        @foreach (auth()->user()->unreadNotifications as $notificacion)
            <div class="alert alert-info d-flex align-items-start">
                <i class="fas fa-info-circle fa-lg mr-3 mt-1"></i>
                <div>
                    <strong>{{ $notificacion->data['mensaje'] }}</strong><br>
                    Producto: {{ $notificacion->data['nombre'] ?? 'Sin nombre' }}<br>
                    Motivo: {{ $notificacion->data['motivo'] ?? 'No especificado' }}<br>
                    <small class="text-muted">Recibido: {{ $notificacion->created_at->diffForHumans() }}</small>
                </div>
            </div>
        @endforeach
    @else
        <div class="alert alert-light text-center">
            <i class="fas fa-inbox fa-2x text-muted mb-2"></i>
            <p class="mb-0">No tienes notificaciones por el momento.</p>
        </div>
    @endif
@endsection
