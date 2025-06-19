@extends('adminlte::page')

@section('title', 'Categorías')

@section('content_header')
    <h1>Categorías</h1>
@stop

@section('content')
    @if(session('success')) 
        <div class="alert alert-success">{{ session('success') }}</div> 
    @endif

    <a href="{{ route('admin.categorias.create') }}" class="btn btn-primary mb-3">
        <i class="fas fa-plus"></i> Nueva Categoría
    </a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($categorias as $categoria)
                <tr>
                    <td>{{ $categoria->nombre }}</td>
                    <td>
                        <a href="{{ route('admin.categorias.edit', $categoria) }}" class="btn btn-sm btn-warning">Editar</a>
                        <form action="{{ route('admin.categorias.destroy', $categoria) }}" method="POST" style="display:inline;">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro de eliminar esta categoría?')">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $categorias->links() }}
@stop
