@extends('adminlte::page')

@section('content')
<div class="container">
    <h3>Chat con {{ Auth::id() === $conversacion->user1_id ? $conversacion->user2->name : $conversacion->user1->name }}</h3>

    <div class="border p-3 mb-3" style="height:300px; overflow-y:auto;">
        @foreach($conversacion->mensajes as $mensaje)
            <p><strong>{{ $mensaje->de_id == Auth::id() ? 'Yo' : 'Ello' }}:</strong> {{ $mensaje->mensaje }}</p>
        @endforeach
    </div>

    <form method="POST" action="{{ route('chat.enviar', $conversacion->id) }}">
        @csrf
        <div class="input-group">
            <input type="text" name="mensaje" class="form-control" placeholder="Escribe un mensaje..." required>
            <button class="btn btn-primary">Enviar</button>
        </div>
    </form>
</div>
@endsection
