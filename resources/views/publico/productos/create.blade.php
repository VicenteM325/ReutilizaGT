@extends('adminlte::page')

@section('content')
<div class="container">
    <div class="card shadow-sm">
        <div class="card-header bg-gradient-primary text-white">
            <h2 class="mb-0"><i class="fas fa-plus-circle mr-2"></i>Nueva Publicación</h2>
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

            <form action="{{ route('mis-productos.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label for="titulo" class="form-label font-weight-bold">Título del Producto</label>
                    <input type="text" name="titulo" class="form-control rounded" value="{{ old('titulo') }}" required placeholder="Ej: Mesa de madera">
                </div>

                <div class="mb-3">
                    <label for="descripcion" class="form-label font-weight-bold">Descripción</label>
                    <textarea name="descripcion" class="form-control rounded" rows="4" required placeholder="Describe tu producto en detalle...">{{ old('descripcion') }}</textarea>
                </div>

                <div class="mb-3">
                    <label for="categoria_id" class="form-label font-weight-bold">Categoría</label>
                    <select name="categoria_id" class="form-select rounded" required>
                        <option value="">Seleccione una categoría</option>
                        @foreach($categorias as $categoria)
                            <option value="{{ $categoria->id }}" {{ old('categoria_id') == $categoria->id ? 'selected' : '' }}>
                                {{ $categoria->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="mb-3">
                    <label for="ubicacion" class="form-label font-weight-bold">Ubicación</label>
                    <input type="text" name="ubicacion" class="form-control rounded" value="{{ old('ubicacion') }}" required placeholder="Ej: 16 Avenida Zona 3 , Quetzaltenango">
                </div>

                <div class="mb-4">
                    <label for="imagen" class="form-label font-weight-bold">Imagen del Producto (opcional)</label>
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
                    <button type="submit" class="btn btn-primary rounded-pill px-4">
                        <i class="fas fa-paper-plane mr-1"></i> Publicar
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
        var fileName = document.getElementById("customFile").files[0].name;
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
</style>
@endsection