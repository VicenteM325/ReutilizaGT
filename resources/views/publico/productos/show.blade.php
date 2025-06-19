@extends('adminlte::page')

@section('content')
<div class="container">
    <h2 class="mb-4">Detalles de la Publicación</h2>

    <div class="card">
        <div class="card-header">
            <h3>{{ $mis_producto->titulo }}</h3>
        </div>
        <div class="card-body">
            @if($mis_producto->imagen)
                <img src="{{ asset('storage/' . $mis_producto->imagen) }}" alt="Imagen de {{ $mis_producto->titulo }}" class="img-fluid mb-3" style="max-height: 300px;">
            @else
                <p class="text-muted">Sin imagen disponible</p>
            @endif

            <p><strong>Categoría:</strong> {{ $mis_producto->categoria->nombre }}</p>

            <p><strong>Descripción:</strong></p>
            <p>{{ $mis_producto->descripcion }}</p>

            <p><strong>Ubicación:</strong></p>
            <p>{{ $mis_producto->ubicacion }}</p>

            <p><strong>Estado:</strong>
                @if($mis_producto->estado === 'pendiente')
                    <span class="badge bg-warning text-dark">Pendiente</span>
                @elseif($mis_producto->estado === 'aprobado')
                    <span class="badge bg-success">Aprobado</span>
                @else
                    <span class="badge bg-danger">Rechazado</span>
                @endif
            </p>

            <p><strong>Vistas:</strong> {{ $mis_producto->vistas }}</p>
        </div>
        <div class="card-footer text-end">
            <a href="{{ route('mis-productos.index') }}" class="btn btn-secondary">Regresar</a>
            <a href="{{ route('mis-productos.edit', $mis_producto) }}" class="btn btn-warning">Editar</a>
        </div>
    </div>
</div>
@endsection
