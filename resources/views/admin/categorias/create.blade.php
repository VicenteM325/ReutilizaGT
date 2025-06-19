@extends('adminlte::page')

@section('title', 'Nueva Categoría')

@section('content_header')
    <h1>Crear Categoría</h1>
@stop

@section('content')
    <form action="{{ route('admin.categorias.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre de la Categoría</label>
            <input type="text" name="nombre" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="nombre" class="form-label">Descripción</label>
            <input type="text" name="descripcion" class="form-control" required>
        </div>

        <a href="{{ route('admin.categorias.index') }}" class="btn btn-secondary">Cancelar</a>
        <button type="submit" class="btn btn-success">Guardar</button>
    </form>
@stop
