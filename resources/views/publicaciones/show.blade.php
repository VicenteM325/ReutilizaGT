@extends('adminlte::page')

@section('title', $producto->titulo)

@section('content_header')
    <h1>{{ $producto->titulo }}</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            @if($producto->imagen)
                <img src="{{ asset('storage/' . $producto->imagen) }}" alt="{{ $producto->titulo }}" class="img-fluid mb-3">
            @endif

            <p><strong>Categoría:</strong> {{ $producto->categoria->nombre }}</p>
            <p><strong>Descripción:</strong> {{ $producto->descripcion }}</p>
            <p><strong>Publicado por:</strong> {{ $producto->user->name }}</p>

            @auth
                @if(auth()->id() !== $producto->user_id)
                    <form action="{{ route('productos.reutilizar', $producto) }}" method="POST">
                        @csrf
                        <button class="btn btn-primary">Solicitar Reutilizar</button>
                    </form>
                @endif
            @endauth
        </div>
    </div>
@stop
