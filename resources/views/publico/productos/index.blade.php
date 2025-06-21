@extends('adminlte::page')

@section('title', 'Mis Publicaciones')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1><i class="fas fa-box-open mr-2"></i>Mis Publicaciones</h1>
        <a href="{{ route('mis-productos.create') }}" class="btn btn-primary">
            <i class="fas fa-plus mr-1"></i> Nueva Publicación
        </a>
    </div>
@stop

@section('content')
<div class="container-fluid">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            <i class="fas fa-exclamation-circle mr-2"></i>{{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if($productos->count())
        <div class="card shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="thead-light">
                            <tr>
                                <th style="width: 100px;">Imagen</th>
                                <th>Título</th>
                                <th>Categoría</th>
                                <th>Estado</th>
                                <th>Vistas</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($productos as $producto)
                                <tr>
                                    <td>
                                        @if($producto->imagen)
                                            <img src="{{ asset('storage/' . $producto->imagen) }}" 
                                                 class="img-thumbnail" 
                                                 style="width: 80px; height: 80px; object-fit: cover;">
                                        @else
                                            <div class="bg-light d-flex align-items-center justify-content-center" 
                                                 style="width: 80px; height: 80px;">
                                                <i class="fas fa-image text-muted"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="align-middle">{{ Str::limit($producto->titulo, 30) }}</td>
                                    <td class="align-middle">{{ $producto->categoria->nombre }}</td>
                                    <td class="align-middle">
                                        @if($producto->estado === 'pendiente')
                                            <span class="badge badge-warning">Pendiente</span>
                                        @elseif($producto->estado === 'aprobado')
                                            <span class="badge badge-success">Aprobado</span>
                                        @else
                                            <span class="badge badge-danger">Rechazado</span>
                                        @endif
                                    </td>
                                    <td class="align-middle">{{ $producto->vistas }}</td>
                                    <td class="align-middle">
                                        <div class="d-flex flex-wrap gap-2">
                                            <a href="{{ route('mis-productos.show', $producto) }}" 
                                               class="btn btn-sm btn-info">
                                                Ver
                                            </a>

                                            @if (!$producto->entregado && $producto->estado === 'aprobado')
                                                <a href="{{ route('mis-productos.edit', $producto) }}" 
                                                   class="btn btn-sm btn-warning">
                                                    Editar
                                                </a>

                                                <form action="{{ route('mis-productos.destroy', $producto) }}" 
                                                      method="POST" 
                                                      class="d-inline"
                                                      onsubmit="return confirm('¿Eliminar esta publicación?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger">
                                                        Eliminar
                                                    </button>
                                                </form>

                                                <form action="{{ route('mis-productos.entregar', $producto) }}" 
                                                      method="POST" 
                                                      class="d-inline"
                                                      onsubmit="return confirm('¿Marcar como entregado?')">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit" class="btn btn-sm btn-secondary">
                                                        Marcar como Entregado
                                                    </button>
                                                </form>

                                            @elseif ($producto->entregado && !$producto->finalizado)
                                                {{-- Producto entregado pero pendiente de confirmación --}}
                                                <span class="badge badge-warning align-self-center">
                                                    Pendiente de confirmación
                                                </span>

                                                <form action="{{ route('mis-productos.destroy', $producto) }}" 
                                                      method="POST" 
                                                      class="d-inline"
                                                      onsubmit="return confirm('¿Eliminar esta publicación?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger">
                                                        Eliminar
                                                    </button>
                                                </form>

                                            @elseif ($producto->finalizado)
                                                {{-- Producto entregado y confirmado --}}
                                                <form action="{{ route('mis-productos.destroy', $producto) }}" 
                                                      method="POST" 
                                                      class="d-inline"
                                                      onsubmit="return confirm('¿Eliminar esta publicación?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger">
                                                        Eliminar
                                                    </button>
                                                </form>

                                                <span class="d-inline-flex align-items-center text-muted small">
                                                    <i class="fas fa-check-circle text-success mr-1"></i> Finalizado
                                                </span>
                                            @else
                                                {{-- Otros casos, solo permitir eliminar --}}
                                                <form action="{{ route('mis-productos.destroy', $producto) }}" 
                                                      method="POST" 
                                                      class="d-inline"
                                                      onsubmit="return confirm('¿Eliminar esta publicación?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger">
                                                        Eliminar
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            
            @if($productos->hasPages())
                <div class="card-footer">
                    {{ $productos->links() }}
                </div>
            @endif
        </div>
    @else
        <div class="alert alert-info text-center py-4">
            <i class="fas fa-inbox fa-3x mb-3 text-muted"></i>
            <h4>Aún no has publicado ningún artículo</h4>
            <p class="mb-0">¡Crea tu primera publicación y empieza a compartir!</p>
            <a href="{{ route('mis-productos.create') }}" class="btn btn-primary mt-3">
                <i class="fas fa-plus mr-1"></i> Crear Publicación
            </a>
        </div>
    @endif
</div>
@endsection

@section('css')
<style>
    .table th {
        border-top: none;
        font-weight: 600;
    }
    .thead-light {
        background-color: #f8f9fa;
    }
    .img-thumbnail {
        padding: 0.25rem;
        background-color: #fff;
        border: 1px solid #dee2e6;
        border-radius: 0.25rem;
    }
    .gap-2 {
        gap: 0.5rem;
    }
</style>
@endsection

@section('js')
<script>
    $(document).ready(function() {
        // Cerrar automáticamente las alertas después de 5 segundos
        setTimeout(function() {
            $('.alert').alert('close');
        }, 7000);
    });
</script>
@endsection