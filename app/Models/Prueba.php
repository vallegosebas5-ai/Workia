<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prueba extends Model
{
    protected $fillable = [
        'oferta_id', 'titulo', 'descripcion', 'url_formulario', 'duracion_minutos', 'activa',
    ];

    protected function casts(): array
    {
        return ['activa' => 'boolean'];
    }

    public function oferta() { return $this->belongsTo(Oferta::class); }
}
