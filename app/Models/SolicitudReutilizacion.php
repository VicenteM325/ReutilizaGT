<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SolicitudReutilizacion extends Model
{
    protected $fillable = ['producto_id', 'solicitante_id', 'estado'];

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }

    public function solicitante()
    {
        return $this->belongsTo(User::class, 'solicitante_id');
    }
}
