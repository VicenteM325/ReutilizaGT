@extends('adminlte::page')

@section('content')
<div class="container">
    <div class="card shadow-sm">
        <div class="card-header bg-gradient-info text-white">
            <h2 class="mb-0"><i class="fas fa-edit mr-2"></i>Editar Publicación</h2>
        </div>

        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <strong>¡Ups!</strong> Hay algunos problemas con los datos ingresados.<br><br>
                    <ul class="mb-0">
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
                    <label for="titulo" class="form-label font-weight-bold">Título del Producto</label>
                    <input type="text" name="titulo" class="form-control rounded" value="{{ old('titulo', $mis_producto->titulo) }}" required placeholder="Ej: Mesa de madera vintage">
                </div>

                <div class="mb-3">
                    <label for="descripcion" class="form-label font-weight-bold">Descripción</label>
                    <textarea name="descripcion" class="form-control rounded" rows="4" required placeholder="Describe tu producto en detalle...">{{ old('descripcion', $mis_producto->descripcion) }}</textarea>
                </div>

                <div class="mb-3">
                    <label for="ubicacion" class="form-label font-weight-bold">Ubicación</label>
                    <input type="text" name="ubicacion" class="form-control rounded" value="{{ old('ubicacion', $mis_producto->ubicacion) }}" required placeholder="Ej: Av. Principal #123, Ciudad">
                </div>

                <div class="mb-3">
                    <label for="categoria_id" class="form-label font-weight-bold">Categoría</label>
                    <select name="categoria_id" class="form-select rounded" required>
                        <option value="">Seleccione una categoría</option>
                        @foreach($categorias as $categoria)
                            <option value="{{ $categoria->id }}" {{ old('categoria_id', $mis_producto->categoria_id) == $categoria->id ? 'selected' : '' }}>
                                {{ $categoria->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label font-weight-bold">Imagen actual</label><br>
                    @if($mis_producto->imagen)
                        <div class="border rounded p-2 d-inline-block">
                            <img src="{{ asset('storage/' . $mis_producto->imagen) }}" alt="Imagen actual" class="img-thumbnail mb-2" style="max-height: 150px;">
                            <div class="text-center">
                                <small class="text-muted">Previsualización actual</small>
                            </div>
                        </div>
                    @else
                        <span class="text-muted"><i class="fas fa-image mr-1"></i> No hay imagen cargada</span>
                    @endif
                </div>

                <div class="mb-4">
                    <label for="imagen" class="form-label font-weight-bold">Cambiar Imagen (opcional)</label>
                    <div class="custom-file">
                        <input type="file" name="imagen" class="custom-file-input" id="customFile" accept="image/*">
                        <label class="custom-file-label rounded" for="customFile">Elegir archivo...</label>
                    </div>
                    <small class="form-text text-muted">Formatos aceptados: JPG, PNG, GIF (Max. 2MB)</small>
                </div>

                <div class="text-end">
                    <a href="{{ route('mis-productos.index') }}" class="btn btn-outline-secondary rounded-pill px-4">
                        <i class="fas fa-times mr-1"></i> Cancelar
                    </a>
                    <button type="submit" class="btn btn-info rounded-pill px-4">
                        <i class="fas fa-save mr-1"></i> Actualizar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('js')
<script>
    // Script para mostrar el nombre del archivo seleccionado
    document.querySelector('.custom-file-input').addEventListener('change', function(e) {
        var fileName = document.getElementById("customFile").files[0]?.name || "Elegir archivo...";
        var nextSibling = e.target.nextElementSibling;
        nextSibling.innerText = fileName;
    });
</script>
@endpush

<style>
    .card {
        border-radius: 10px;
        overflow: hidden;
    }
    .form-control, .form-select, .custom-file-label {
        border: 1px solid #ced4da;
        transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    }
    .form-control:focus, .form-select:focus {
        border-color: #80bdff;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }
    .btn {
        transition: all 0.3s ease;
    }
    .bg-gradient-info {
        background: linear-gradient(45deg, #17a2b8, #1abc9c);
    }
</style>
@endsection