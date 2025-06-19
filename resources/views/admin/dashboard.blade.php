@extends('adminlte::page')

@section('title', 'Panel de Administración')

@section('content_header')
    <h1>Panel de Administración</h1>
@stop

@section('content')
<div class="row">
    <div class="col-lg-4 col-6">
        <div class="small-box bg-primary">
            <div class="inner">
                <h3>{{ \App\Models\User::count() }}</h3>
                <p>Usuarios Registrados</p>
            </div>
            <div class="icon">
                <i class="fas fa-users"></i>
            </div>
            <a href="{{ route('admin.usuarios.index') }}" class="small-box-footer">
                Ver usuarios <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>

    <div class="col-lg-4 col-6">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{ \App\Models\Producto::count() }}</h3>
                <p>Publicaciones</p>
            </div>
            <div class="icon">
                <i class="fas fa-box"></i>
            </div>
            <a href="{{ route('moderacion.productos.index') }}" class="small-box-footer">
                Ver publicaciones <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>

    <div class="col-lg-4 col-6">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>{{ \App\Models\Categoria::count() }}</h3>
                <p>Categorías</p>
            </div>
            <div class="icon">
                <i class="fas fa-tags"></i>
            </div>
            <a href="{{ route('admin.categorias.index') }}" class="small-box-footer">
                Ver categorías <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
</div>
@stop
