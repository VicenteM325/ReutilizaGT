@extends('adminlte::page')

@section('title', 'Revisar Publicaciones')

@section('content_header')
    <h1>Publicaciones Pendientes</h1>
@stop

@section('content')
@if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
@if(session('error')) <div class="alert alert-danger">{{ session('error') }}</div> @endif

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Título</th>
            <th>Categoría</th>
            <th>Usuario</th>
            <th>Imagen</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach($productos as $producto)
            <tr>
                <td>{{ $producto->titulo }}</td>
                <td>{{ $producto->categoria->nombre }}</td>
                <td>{{ $producto->user->name }}</td>
                <td>
                    @if($producto->imagen)
                        <img src="{{ asset('storage/' . $producto->imagen) }}" width="80">
                    @endif
                </td>
                <td>
                    <form action="{{ route('moderacion.productos.aprobar', $producto) }}" method="POST" style="display:inline;">
                        @csrf @method('PUT')
                        <button class="btn btn-success btn-sm">Aprobar</button>
                    </form>
                    <form action="{{ route('moderacion.productos.rechazar', $producto) }}" method="POST" style="display:inline;">
                        @csrf @method('PUT')
                        <button class="btn btn-danger btn-sm">Rechazar</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

{{ $productos->links() }}
@stop
