@extends('adminlte::page')

@section('content')
<div class="container">
    <h2 class="mb-4">Mis Publicaciones</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="mb-3 text-end">
        <a href="{{ route('mis-productos.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Nueva Publicación
        </a>
    </div>

    @if($productos->count())
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>Imagen</th>
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
                            <td style="width: 100px;">
                                @if($producto->imagen)
                                    <img src="{{ asset('storage/' . $producto->imagen) }}" class="img-thumbnail" width="80">
                                @else
                                    <span class="text-muted">Sin imagen</span>
                                @endif
                            </td>
                            <td>{{ $producto->titulo }}</td>
                            <td>{{ $producto->categoria->nombre }}</td>
                            <td>
                                @if($producto->estado === 'pendiente')
                                    <span class="badge bg-warning text-dark">Pendiente</span>
                                @elseif($producto->estado === 'aprobado')
                                    <span class="badge bg-success">Aprobado</span>
                                @else
                                    <span class="badge bg-danger">Rechazado</span>
                                @endif
                            </td>
                            <td>{{ $producto->vistas }}</td>
                            <td>
                                <a href="{{ route('mis-productos.show', $producto) }}" class="btn btn-sm btn-info">Ver</a>
                                <a href="{{ route('mis-productos.edit', $producto) }}" class="btn btn-sm btn-warning">Editar</a>
                                <form action="{{ route('mis-productos.destroy', $producto) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('¿Eliminar esta publicación?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{ $productos->links() }}
    @else
        <div class="alert alert-info">
            Aún no has publicado ningún artículo. ¡Empieza ahora!
        </div>
    @endif
</div>
@endsection
