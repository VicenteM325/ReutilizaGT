<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Producto extends Model
{
    use HasFactory;

    protected $fillable = [
        'titulo',
        'descripcion',
        'imagen',
        'ubicacion',
        'categoria_id',
        'estado',
        'user_id',
    ];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    public function conversaciones()
    {
        return $this->hasMany(Conversacion::class, 'producto_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function scopePendientes($query)
    {
    return $query->where('estado', 'pendiente');
    }

    public function scopeAprobados($query)
    {
    return $query->where('estado', 'aprobado');
    }

    public function scopePorCategoria($query, $categoriaId)
    {
    if ($categoriaId) {
        return $query->where('categoria_id', $categoriaId);
    }
    return $query;
    }

    public function scopeBuscar($query, $keyword)
    {
    if ($keyword) {
        return $query->where('titulo', 'like', "%$keyword%")
                     ->orWhere('descripcion', 'like', "%$keyword%");
    }
    return $query;
    }

    public function scopeOrdenar($query, $orden)
    {
    switch ($orden) {
        case 'recientes':
            return $query->orderBy('created_at', 'desc');
        case 'vistas':
            return $query->orderBy('vistas', 'desc');
        default:
            return $query;
    }
    }
}
