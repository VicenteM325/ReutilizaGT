@extends('adminlte::page')

@section('title', 'Chat - ' . (Auth::id() === $conversacion->user1_id ? $conversacion->usuario2->name : $conversacion->usuario1->name))

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>
            <i class="fas fa-comments mr-2"></i>
            Chat con {{ Auth::id() === $conversacion->user1_id ? $conversacion->usuario2->name : $conversacion->usuario1->name }}
        </h1>
        <a href="{{ route('chat.index') }}" class="btn btn-sm btn-outline-secondary">
            <i class="fas fa-arrow-left"></i> Volver
        </a>
    </div>
    <div class="mt-2">
        <span class="badge badge-light">
            <i class="fas fa-tag mr-1"></i>
            {{ $conversacion->producto->titulo ?? 'Producto no disponible' }}
        </span>
    </div>
@stop

@section('content')
<div class="container-fluid">
    <div class="card shadow-sm">
        <div class="card-body p-0">
            <!-- Área de mensajes -->
            <div id="chat-messages" class="p-3" style="height: 65vh; overflow-y: auto; background-color: #f8f9fa;">
                @foreach($conversacion->mensajes as $mensaje)
                    <div class="message-wrapper @if($mensaje->de_id == Auth::id()) justify-content-end @else justify-content-start @endif mb-3 d-flex">
                        <div class="message @if($mensaje->de_id == Auth::id()) bg-primary text-white @else bg-white @endif rounded-lg p-3 shadow-sm" style="max-width: 70%;">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <strong class="@if($mensaje->de_id == Auth::id()) text-white @endif">
                                    {{ $mensaje->de_id == Auth::id() ? 'Yo' : $mensaje->remitente->name }}
                                </strong>
                                <small class="@if($mensaje->de_id == Auth::id()) text-white-50 @else text-muted @endif ml-2">
                                    {{ $mensaje->created_at->diffForHumans() }}
                                </small>
                            </div>
                            <div class="message-content">
                                {{ $mensaje->mensaje }}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Formulario de envío  -->
            <div class="border-top p-3 bg-light">
                <form method="POST" action="{{ route('chat.enviar', $conversacion->id) }}">
                    @csrf
                    <div class="input-group">
                        <input type="text" name="mensaje" class="form-control rounded-pill mr-2" 
                               placeholder="Escribe un mensaje..." required autocomplete="off" autofocus>
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-primary rounded-pill">
                                <i class="fas fa-paper-plane"></i> Enviar
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('css')
<style>
    .message {
        transition: transform 0.2s, box-shadow 0.2s;
    }
    
    .message:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
    
    #chat-messages {
        scroll-behavior: smooth;
    }
    
    /* Estilo para la barra de scroll */
    #chat-messages::-webkit-scrollbar {
        width: 8px;
    }
    
    #chat-messages::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }
    
    #chat-messages::-webkit-scrollbar-thumb {
        background: #c1c1c1;
        border-radius: 10px;
    }
    
    #chat-messages::-webkit-scrollbar-thumb:hover {
        background: #a8a8a8;
    }
</style>
@endsection

@section('js')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const chatMessages = document.getElementById('chat-messages');
        chatMessages.scrollTop = chatMessages.scrollHeight;

        const messageInput = document.querySelector('input[name="mensaje"]');
        if (messageInput) {
            messageInput.focus();
        }
    });
</script>
@endsection