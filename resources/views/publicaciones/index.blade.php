@extends('adminlte::page')

@section('title', 'Explorador de Publicaciones')

@section('content_header')
<h1>Explorador de Publicaciones</h1>
@stop

@section('content')
<form method="GET" action="{{ route('publicaciones.index') }}" class="mb-4">
    <div class="row g-2">
        <div class="col-md-3">
            <select name="categoria_id" class="form-select">
                <option value="">Todas las categorías</option>
                @foreach($categorias as $categoria)
                    <option value="{{ $categoria->id }}" {{ request('categoria_id') == $categoria->id ? 'selected' : '' }}>
                        {{ $categoria->nombre }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4">
            <input type="search" name="q" class="form-control" placeholder="Buscar..." value="{{ request('q') }}">
        </div>
        <div class="col-md-3">
            <select name="orden" class="form-select">
                <option value="">Ordenar por</option>
                <option value="recientes" {{ request('orden') == 'recientes' ? 'selected' : '' }}>Más recientes</option>
                <option value="vistas" {{ request('orden') == 'vistas' ? 'selected' : '' }}>Más vistas</option>
            </select>
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-primary w-100">Filtrar</button>
        </div>
    </div>
</form>

<div class="row">
    @foreach($productos as $producto)
        <div class="col-md-3 mb-4">
            <div class="card h-100">
                @if($producto->imagen)
                    <img src="{{ asset('storage/' . $producto->imagen) }}" class="card-img-top" alt="Imagen de {{ $producto->titulo }}">
                @endif
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title">{{ $producto->titulo }}</h5>
                    <p class="card-text text-truncate">{{ $producto->descripcion }}</p>
                    <p><small class="text-muted">{{ $producto->categoria->nombre }}</small></p>
                    <a href="{{ route('publicaciones.show', $producto) }}" class="btn btn-primary mt-auto">Ver detalles</a>
                    <form action="{{ route('productos.reutilizar', $producto) }}" method="POST">
                     @csrf
                    <button type="submit" class="btn btn-warning">Reutilizar</button>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
</div>

{{ $productos->links() }}
@stop
