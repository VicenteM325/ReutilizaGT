@extends('adminlte::page')

@section('content')
<div class="container">
    <div class="card shadow-lg">
        <div class="card-header bg-gradient-primary text-white">
            <div class="d-flex justify-content-between align-items-center">
                <h3 class="mb-0"><i class="fas fa-info-circle mr-2"></i>Detalles de la Publicación</h3>
                <span class="badge bg-light text-dark fs-6">
                    <i class="fas fa-eye mr-1"></i> {{ $mis_producto->vistas }} vistas
                </span>
            </div>
        </div>
        
        <div class="card-body">
            <!-- Imagen principal -->
            <div class="text-center mb-4">
                @if($mis_producto->imagen)
                    <img src="{{ asset('storage/' . $mis_producto->imagen) }}" 
                         alt="Imagen de {{ $mis_producto->titulo }}" 
                         class="img-fluid rounded shadow-sm" 
                         style="max-height: 400px; border: 1px solid #eee;">
                @else
                    <div class="bg-light p-5 rounded text-muted">
                        <i class="fas fa-image fa-4x mb-3"></i>
                        <p class="mb-0">No hay imagen disponible</p>
                    </div>
                @endif
            </div>

            <!-- Información detallada -->
            <div class="row">
                <div class="col-md-8">
                    <h4 class="text-primary">{{ $mis_producto->titulo }}</h4>
                    <p class="text-muted mb-4">
                        <i class="fas fa-tag mr-1"></i> {{ $mis_producto->categoria->nombre }}
                    </p>
                    
                    <div class="mb-4">
                        <h5><i class="fas fa-align-left text-secondary mr-2"></i>Descripción</h5>
                        <p class="text-justify bg-light p-3 rounded">{{ $mis_producto->descripcion }}</p>
                    </div>
                    
                    <div class="mb-4">
                        <h5><i class="fas fa-map-marker-alt text-secondary mr-2"></i>Ubicación</h5>
                        <p class="bg-light p-3 rounded">{{ $mis_producto->ubicacion }}</p>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-light">
                            <h5 class="mb-0">Estado de la Publicación</h5>
                        </div>
                        <div class="card-body text-center">
                            @if($mis_producto->estado === 'pendiente')
                                <span class="badge bg-warning text-dark p-3 fs-6">
                                    <i class="fas fa-clock mr-2"></i> Pendiente
                                </span>
                            @elseif($mis_producto->estado === 'aprobado')
                                <span class="badge bg-success p-3 fs-6">
                                    <i class="fas fa-check-circle mr-2"></i> Aprobado
                                </span>
                            @else
                                <span class="badge bg-danger p-3 fs-6">
                                    <i class="fas fa-times-circle mr-2"></i> Rechazado
                                </span>
                            @endif
                            
                            <hr>
                            
                            <div class="text-start">
                                <p><strong><i class="fas fa-calendar-alt mr-2"></i>Publicado:</strong> 
                                   {{ $mis_producto->created_at->format('d/m/Y H:i') }}</p>
                                @if($mis_producto->updated_at != $mis_producto->created_at)
                                    <p><strong><i class="fas fa-edit mr-2"></i>Última actualización:</strong> 
                                       {{ $mis_producto->updated_at->format('d/m/Y H:i') }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="card-footer bg-light text-end">
            <a href="{{ route('mis-productos.index') }}" class="btn btn-outline-secondary rounded-pill px-4">
                <i class="fas fa-arrow-left mr-1"></i> Regresar
            </a>
            <a href="{{ route('mis-productos.edit', $mis_producto) }}" class="btn btn-warning rounded-pill px-4">
                <i class="fas fa-edit mr-1"></i> Editar
            </a>
        </div>
    </div>
</div>

<style>
    .card {
        border-radius: 12px;
        overflow: hidden;
    }
    .card-header {
        border-bottom: none;
    }
    .bg-gradient-primary {
        background: linear-gradient(45deg, #4e73df, #224abe);
    }
    .badge {
        border-radius: 50px;
        padding: 8px 16px;
    }
    .rounded-pill {
        border-radius: 50px !important;
    }
    .shadow-sm {
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075) !important;
    }
    .shadow-lg {
        box-shadow: 0 1rem 3rem rgba(0, 0, 0, 0.175) !important;
    }
</style>
@endsection