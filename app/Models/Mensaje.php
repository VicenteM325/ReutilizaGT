<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mensaje extends Model
{
    protected $fillable = ['conversacion_id', 'de_id', 'para_id', 'mensaje'];

    public function remitente()
    {
        return $this->belongsTo(User::class, 'de_id');
    }

    public function destinatario()
    {
        return $this->belongsTo(User::class, 'para_id');
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }
    public function conversacion()
    {
    return $this->belongsTo(Conversacion::class);
    }

    
}
