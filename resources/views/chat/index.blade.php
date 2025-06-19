@extends('adminlte::page')

@section('title', 'Mis Conversaciones')

@section('content_header')
    <h1 class="mb-2">Mis Conversaciones</h1>
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
@stop

@section('content')
<div class="container-fluid">
    <div class="card shadow-sm">
        <div class="card-body p-0">
            @forelse($conversaciones as $conv)
                @php
                    $otroUsuario = Auth::id() === $conv->user1_id ? $conv->usuario2 : $conv->usuario1;
                    $mensajesNoLeidos = $conv->mensajes->where('para_id', Auth::id())->where('leido', false)->count();
                    $ultimoMensaje = $conv->mensajes->sortByDesc('created_at')->first();
                @endphp
                
                <a href="{{ route('chat.mostrar', $conv->id) }}" 
                   class="conversation-item d-flex justify-content-between align-items-center p-3 border-bottom">
                    <div class="d-flex align-items-center">
                        <div class="mr-3">
                            <img src="{{ $otroUsuario->profile_photo_url ?? asset('img/default-user.png') }}" 
                                 alt="{{ $otroUsuario->name }}" 
                                 class="rounded-circle" 
                                 width="50" 
                                 height="50">
                        </div>
                        <div>
                            <h6 class="mb-1 font-weight-bold">{{ $otroUsuario->name }}</h6>
                            <p class="mb-1 text-muted small">
                                @if($ultimoMensaje)
                                    {{ Str::limit($ultimoMensaje->contenido, 50) }}
                                @else
                                    Sin mensajes aún
                                @endif
                            </p>
                            <small class="text-primary">
                                <i class="fas fa-box-open mr-1"></i>
                                {{ $conv->producto->titulo ?? 'Producto no disponible' }}
                            </small>
                        </div>
                    </div>
                    <div class="text-right">
                        @if($ultimoMensaje)
                            <small class="d-block text-muted mb-1">
                                {{ $ultimoMensaje->created_at->diffForHumans() }}
                            </small>
                        @endif
                        @if($mensajesNoLeidos > 0)
                            <span class="badge badge-danger badge-pill">{{ $mensajesNoLeidos }}</span>
                        @endif
                    </div>
                </a>
            @empty
                <div class="text-center p-5">
                    <i class="far fa-comments fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">No tienes conversaciones activas</h5>
                    <p class="text-muted">Cuando inicies una conversación sobre un producto, aparecerá aquí.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection

@section('css')
<style>
    .conversation-item {
        color: inherit;
        text-decoration: none;
        transition: background-color 0.2s;
    }
    
    .conversation-item:hover {
        background-color: #f8f9fa;
        text-decoration: none;
    }
    
    .card {
        border-radius: 0.75rem;
        overflow: hidden;
    }
    
    .badge-pill {
        min-width: 1.5rem;
    }
</style>
@endsection