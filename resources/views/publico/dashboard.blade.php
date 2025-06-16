@extends('adminlte::page')

@section('content')
    <div class="container">
        <h1>Bienvenido Usuario Público</h1>
        <a href="{{ route('mis-productos.index') }}" class="btn btn-primary mt-3">Mis Productos</a>
    </div>
@endsection
