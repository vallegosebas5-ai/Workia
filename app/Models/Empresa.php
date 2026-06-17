<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    protected $fillable = [
        'user_id', 'razon_social', 'nit', 'rubro', 'descripcion',
        'logo', 'sitio_web', 'direccion', 'ciudad', 'telefono', 'verificada',
    ];

    protected function casts(): array
    {
        return ['verificada' => 'boolean'];
    }

    public function user() { return $this->belongsTo(User::class); }
    public function ofertas() { return $this->hasMany(Oferta::class); }
}
