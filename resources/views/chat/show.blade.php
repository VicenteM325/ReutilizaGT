@extends('adminlte::page')

@section('title', 'Chat sobre: ' . $producto->titulo)

@section('content_header')
    <h1>Chat sobre: {{ $producto->titulo }}</h1>
@stop

@section('content')
<div class="row">
    <div class="col-md-12">
        <!-- Chat box -->
        <div class="card card-primary card-outline direct-chat direct-chat-primary">
            <div class="card-header">
                <h3 class="card-title">Conversación</h3>
            </div>

            <div class="card-body">
                <div class="direct-chat-messages" style="height: 300px;">
                    @foreach($mensajes as $mensaje)
                        @if ($mensaje->de_id === auth()->id())
                            <!-- Mensaje enviado -->
                            <div class="direct-chat-msg right">
                                <div class="direct-chat-infos clearfix">
                                    <span class="direct-chat-name float-right">{{ $mensaje->remitente->name }}</span>
                                    <span class="direct-chat-timestamp float-left">{{ $mensaje->created_at->format('d M, H:i') }}</span>
                                </div>
                                <div class="direct-chat-text bg-primary text-white">
                                    {{ $mensaje->mensaje }}
                                </div>
                            </div>
                        @else
                            <!-- Mensaje recibido -->
                            <div class="direct-chat-msg">
                                <div class="direct-chat-infos clearfix">
                                    <span class="direct-chat-name float-left">{{ $mensaje->remitente->name }}</span>
                                    <span class="direct-chat-timestamp float-right">{{ $mensaje->created_at->format('d M, H:i') }}</span>
                                </div>
                                <div class="direct-chat-text bg-light border">
                                    {{ $mensaje->mensaje }}
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>

            <div class="card-footer">
                <form action="{{ route('chat.enviar', $producto) }}" method="POST">
                    @csrf
                    <div class="input-group">
                        <input type="text" name="mensaje" class="form-control" placeholder="Escribe tu mensaje..." required>
                        <span class="input-group-append">
                            <button type="submit" class="btn btn-primary">Enviar</button>
                        </span>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@stop
