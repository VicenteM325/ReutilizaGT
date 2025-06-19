@extends('adminlte::page')

@section('title', 'Dashboard Moderador')

@section('content_header')
    <h1>Panel de Moderación</h1>
@stop

@section('content')
<div class="row">
    <div class="col-lg-3 col-6">
        <!-- Publicaciones Pendientes -->
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>{{ $pendientes }}</h3>
                <p>Publicaciones Pendientes</p>
            </div>
            <div class="icon">
                <i class="fas fa-hourglass-half"></i>
            </div>
            <a href="{{ route('moderacion.productos.index', ['estado' => 'pendiente']) }}" class="small-box-footer">
                Revisar <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <!-- Publicaciones Aprobadas -->
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{ $aprobados }}</h3>
                <p>Publicaciones Aprobadas</p>
            </div>
            <div class="icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <a href="{{ route('moderacion.productos.index', ['estado' => 'aprobado']) }}" class="small-box-footer">
                Ver aprobadas <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <!-- Publicaciones Rechazados -->
        <div class="small-box bg-danger">
            <div class="inner">
                <h3>{{ $rechazados }}</h3>
                <p>Publicaciones Rechazadas</p>
            </div>
            <div class="icon">
                <i class="fas fa-times-circle"></i>
            </div>
            <a href="{{ route('moderacion.productos.index', ['estado' => 'rechazado']) }}" class="small-box-footer">
                Ver rechazadas <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <!-- Usuarios -->
        <div class="small-box bg-primary">
            <div class="inner">
                <h3>{{ $usuarios }}</h3>
                <p>Usuarios Registrados</p>
            </div>
            <div class="icon">
                <i class="fas fa-users"></i>
            </div>
            <a href="{{ route('admin.usuarios.index') }}" class="small-box-footer">
                Gestionar usuarios <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>

    <div class="col-lg-3 col-6 mt-4">
        <!-- Categorías -->
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ $categorias }}</h3>
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
