<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Producto;

class ProductoRechazado extends Notification
{
    use Queueable;

    public $producto;
    public $motivo;

    public function __construct(Producto $producto, string $motivo)
    {
        $this->producto = $producto;
        $this->motivo = $motivo;
    }

    public function via($notifiable)
    {
        return ['database']; 
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->line('The introduction to the notification.')
            ->action('Notification Action', url('/'))
            ->line('Thank you for using our application!');
    }

    public function toArray($notifiable)
    {
        return [
            'producto_id' => $this->producto->id,
            'nombre' => $this->producto->titulo,
            'estado' => $this->producto->estado,
            'mensaje' => 'Tu producto fue rechazado',
            'motivo' => $this->motivo,
        ];
    }

}
