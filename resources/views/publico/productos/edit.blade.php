@extends('adminlte::page')

@section('content')
<div class="container">
    <h2 class="mb-4">Editar Publicación</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>¡Ups!</strong> Hay algunos problemas con los datos ingresados.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('mis-productos.update', $mis_producto) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="titulo" class="form-label">Título del Producto</label>
            <input type="text" name="titulo" class="form-control" value="{{ old('titulo', $mis_producto->titulo) }}" required>
        </div>

        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <textarea name="descripcion" class="form-control" rows="4" required>{{ old('descripcion', $mis_producto->descripcion) }}</textarea>
        </div>

        <div class="mb-3">
            <label for="descripcion" class="form-label">Ubicación</label>
            <textarea name="descripcion" class="form-control" rows="4" required>{{ old('ubicacion', $mis_producto->ubicacion) }}</textarea>
        </div>

        <div class="mb-3">
            <label for="categoria_id" class="form-label">Categoría</label>
            <select name="categoria_id" class="form-select" required>
                <option value="">Seleccione una categoría</option>
                @foreach($categorias as $categoria)
                    <option value="{{ $categoria->id }}" {{ old('categoria_id', $mis_producto->categoria_id) == $categoria->id ? 'selected' : '' }}>
                        {{ $categoria->nombre }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Imagen actual</label><br>
            @if($mis_producto->imagen)
                <img src="{{ asset('storage/' . $mis_producto->imagen) }}" alt="Imagen actual" class="img-thumbnail mb-2" style="max-height: 150px;">
            @else
                <span class="text-muted">No hay imagen cargada</span>
            @endif
        </div>

        <div class="mb-3">
            <label for="imagen" class="form-label">Cambiar Imagen (opcional)</label>
            <input type="file" name="imagen" class="form-control" accept="image/*">
            <small class="form-text text-muted">Sube una nueva imagen solo si quieres reemplazar la actual.</small>
        </div>

        <div class="text-end">
            <a href="{{ route('mis-productos.index') }}" class="btn btn-secondary">Cancelar</a>
            <button type="submit" class="btn btn-primary">Actualizar</button>
        </div>
    </form>
</div>
@endsection
