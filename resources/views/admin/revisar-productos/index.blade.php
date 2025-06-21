@extends('adminlte::page')

@section('title', 'Revisar Publicaciones')

@section('content_header')
    <h1>Publicaciones</h1>
@stop

@section('content')
@if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
@if(session('error')) <div class="alert alert-danger">{{ session('error') }}</div> @endif

@if($estado)
    <h4>Mostrando Publicaciones en Estado {{ $estado }}</h4>
@endif
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
                    @if($producto->estado === 'pendiente')
                        <form action="{{ route('moderacion.productos.aprobar', $producto) }}" method="POST" style="display:inline;">
                            @csrf @method('PUT')
                            <button class="btn btn-success btn-sm">Aprobar</button>
                        </form>
                        <form action="{{ route('moderacion.productos.rechazar', $producto) }}" method="POST">
                            @csrf
                            @method('PATCH')

                            <textarea name="motivo" placeholder="Motivo del rechazo" required class="form-control mb-2"></textarea>
                            <button type="submit" class="btn btn-danger btn-sm">Rechazar</button>
                        </form>
                    @elseif($producto->estado === 'aprobado')
                        <span class="badge bg-success">Aprobado</span>
                    @elseif($producto->estado === 'rechazado')
                        <span class="badge bg-danger">Rechazado</span>
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

<div class="row">
    <div class="col-12 d-flex justify-content-center">
        {{ $productos->links() }}
    </div>
</div>
@stop
