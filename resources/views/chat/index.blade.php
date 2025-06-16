@extends('adminlte::page')

@section('title', 'Mis Conversaciones')

@section('content')
<div class="container">
    <h3>Mis Conversaciones</h3>

    <div class="list-group">
        @forelse($conversaciones as $conv)
            @php
                $otroUsuario = Auth::id() === $conv->user1_id ? $conv->usuario2 : $conv->usuario1;
            @endphp

            <a href="{{ route('chat.mostrar', $conv->id) }}" class="list-group-item list-group-item-action">
                Conversación con {{ $otroUsuario->name }} <br>
                <small class="text-muted">
                    Producto: {{ $conv->producto->nombre ?? 'N/A' }}
                </small>
            </a>
        @empty
            <p>No tienes conversaciones activas.</p>
        @endforelse
    </div>
</div>
@endsection
