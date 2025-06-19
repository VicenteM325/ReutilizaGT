@extends('adminlte::page')

@section('title', $producto->titulo)

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <a href="{{ route('publicaciones.index') }}" class="btn btn-outline-secondary btn-sm mr-2">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
            <span class="h4">{{ $producto->titulo }}</span>
        </div>
        <small class="text-muted">Publicado {{ $producto->created_at->diffForHumans() }}</small>
    </div>
@stop

@section('content')
<div class="container-fluid">
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <!-- Imagen del producto -->
            @if($producto->imagen)
                <div class="text-center mb-4">
                    <img src="{{ asset('storage/' . $producto->imagen) }}" 
                         alt="{{ $producto->titulo }}" 
                         class="img-fluid rounded" 
                         style="max-height: 400px;">
                </div>
            @endif

            <!-- Información del producto -->
            <div class="row">
                <div class="col-md-8">
                    <div class="mb-4">
                        <h5 class="text-primary">Descripción</h5>
                        <p class="text-muted">{{ $producto->descripcion }}</p>
                    </div>

                    <ul class="list-group list-group-flush mb-4">
                        <li class="list-group-item px-0">
                            <strong>Categoría:</strong> {{ $producto->categoria->nombre }}
                        </li>
                        <li class="list-group-item px-0">
                            <strong>Ubicación:</strong> {{ $producto->ubicacion }}
                        </li>
                        <li class="list-group-item px-0">
                            <strong>Publicado por:</strong> {{ $producto->user->name }}
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Botón de solicitud -->
            @auth
                @if(auth()->id() !== $producto->user_id)
                    <form action="{{ route('productos.reutilizar', $producto) }}" method="POST" class="mt-4">
                        @csrf
                        <button class="btn btn-primary btn-lg">
                            <i class="fas fa-recycle mr-2"></i> Solicitar Reutilización
                        </button>
                    </form>
                @endif
            @endauth
        </div>
    </div>

    <!-- Mensajes flash -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
        </div>
    @endif
    
    @if (session('info'))
        <div class="alert alert-info alert-dismissible fade show">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <i class="fas fa-info-circle mr-2"></i> {{ session('info') }}
        </div>
    @endif
    
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <i class="fas fa-exclamation-circle mr-2"></i> {{ session('error') }}
        </div>
    @endif
</div>
@endsection

@section('css')
<style>
    .list-group-item {
        border-left: none;
        border-right: none;
        padding-left: 0;
    }
    
    .shadow-sm {
        box-shadow: 0 .125rem .25rem rgba(0,0,0,.075);
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