@extends('adminlte::page')

@section('title', 'Explorador de Publicaciones')

@section('content_header')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0 text-dark">Explorador de Publicaciones</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Inicio</a></li>
                <li class="breadcrumb-item active">Publicaciones</li>
            </ol>
        </div>
    </div>
</div>
@stop

@section('content')
<div class="container-fluid">
    <!-- Filtros modernizados -->
    <!-- Bloque de filtros rediseñado -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-white py-3 px-4 d-flex flex-wrap justify-content-between align-items-center">
            <h5 class="mb-0 text-primary d-flex align-items-center">
                <i class="fas fa-sliders-h me-2"></i> Filtros de Publicaciones
            </h5>
            <a href="{{ route('publicaciones.index') }}" class="btn btn-sm btn-light border">
                <i class="fas fa-redo-alt me-1"></i> Limpiar Filtros
            </a>
        </div>

        <div class="card-body px-4 pt-3">
            <form method="GET" action="{{ route('publicaciones.index') }}">
                <div class="row gy-3">
                    <div class="col-lg-4 col-md-6">
                        <label for="categoria_id" class="form-label fw-semibold">Categoría</label>
                        <select name="categoria_id" class="form-select" id="categoria_id">
                            <option value="">Todas las categorías</option>
                            @foreach($categorias as $categoria)
                            <option value="{{ $categoria->id }}" {{ request('categoria_id') == $categoria->id ? 'selected' : '' }}>
                               {{ $categoria->nombre }}
                           </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-lg-4 col-md-6">
                        <label for="orden" class="form-label fw-semibold">Ordenar por</label>
                        <select name="orden" id="orden" class="form-select">
                            <option value="">Predeterminado</option>
                            <option value="recientes" {{ request('orden') == 'recientes' ? 'selected' : '' }}>Más recientes</option>
                            <option value="vistas" {{ request('orden') == 'vistas' ? 'selected' : '' }}>Más vistas</option>
                        </select>
                    </div>

                    <div class="col-lg-4 col-md-12">
                        <label for="search" class="form-label fw-semibold">Buscar</label>
                        <div class="input-group">
                            <input type="search" name="q" id="search" class="form-control" placeholder="Buscar publicaciones..." value="{{ request('q') }}">
                            <button class="btn btn-outline-primary" type="submit">
                                <i class="fas fa-search me-1"></i> Buscar
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Alertas modernas -->
    @if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if (session('info'))
    <div class="alert alert-info alert-dismissible fade show" role="alert">
        {{ session('info') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <!-- Grid de publicaciones moderno -->
    @if($productos->isEmpty())
        <div class="text-center py-5">
            <i class="fas fa-box-open fa-4x text-muted mb-3"></i>
            <h3 class="text-muted">No se encontraron publicaciones</h3>
            <p class="text-muted">Intenta ajustar tus filtros de búsqueda</p>
        </div>
    @else
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-4 g-4">
            @foreach($productos as $producto)
                <div class="col">
                    <div class="card h-100 shadow-sm border-0">
                        <!-- Badge de categoría -->
                        <div class="position-absolute end-0 top-0 m-2">
                            <span class="badge bg-primary">{{ $producto->categoria->nombre }}</span>
                        </div>
                        
                        <!-- Imagen con efecto hover -->
                        <div class="overflow-hidden" style="height: 180px;">
                            @if($producto->imagen)
                                <img src="{{ asset('storage/' . $producto->imagen) }}" 
                                     class="card-img-top h-100 object-fit-cover transition-scale" 
                                     alt="{{ $producto->titulo }}">
                            @else
                                <div class="bg-light d-flex align-items-center justify-content-center h-100">
                                    <i class="fas fa-image fa-3x text-muted"></i>
                                </div>
                            @endif
                        </div>
                        
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title text-truncate">{{ $producto->titulo }}</h5>
                            <p class="card-text text-muted mb-3 line-clamp-2">{{ $producto->descripcion }}</p>
                            
                            <div class="mt-auto">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <small class="text-muted">
                                        <i class="far fa-eye me-1"></i> {{ $producto->vistas ?? 0 }} vistas
                                    </small>
                                    <small class="text-muted">
                                        <i class="far fa-calendar-alt me-1"></i> {{ $producto->created_at->diffForHumans() }}
                                    </small>
                                </div>
                                
                                <div class="d-grid gap-2">
                                    <a href="{{ route('publicaciones.show', $producto) }}" 
                                       class="btn btn-outline-primary btn-sm">
                                        <i class="fas fa-search me-1"></i> Ver detalles
                                    </a>
                                    <form action="{{ route('productos.reutilizar', $producto) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-outline-warning btn-sm w-100">
                                            <i class="fas fa-recycle me-1"></i> Reutilizar
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        <!-- Paginación mejorada -->
        <div class="d-flex justify-content-center mt-4">
            {{ $productos->links() }}
        </div>
    @endif
</div>
@stop

@section('css')
<style>
    /* Tarjetas con efecto hover */
    .card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border-radius: 10px;
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    }

    /* Efecto zoom en imágenes al hacer hover */
    .transition-scale {
        transition: transform 0.5s ease;
    }

    .card:hover .transition-scale {
        transform: scale(1.05);
    }

    /* Limitar descripción a dos líneas */
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    /* Botones con transición suave */
    .btn-outline-primary,
    .btn-outline-warning {
        transition: all 0.3s ease;
    }

</style>
@stop


@section('js')
<script>
        // Tooltips
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.forEach(function (tooltipTriggerEl) {
            new bootstrap.Tooltip(tooltipTriggerEl);
        });
</script>
@stop
