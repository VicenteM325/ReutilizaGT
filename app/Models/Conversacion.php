<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Conversacion extends Model
{
    protected $table = 'conversaciones'; 
    protected $fillable = ['producto_id', 'user1_id', 'user2_id'];

    public function mensajes()
    {
        return $this->hasMany(Mensaje::class);
    }

     public function usuario1() {
        return $this->belongsTo(User::class, 'user1_id');
    }

    public function usuario2() {
        return $this->belongsTo(User::class, 'user2_id');
    }

    public function producto(){
        return $this->belongsTo(Producto::class, 'producto_id');
    }
}
