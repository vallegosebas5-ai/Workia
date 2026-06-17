<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Postulacion extends Model
{
    protected $table = 'postulaciones';
    protected $fillable = [
        'oferta_id', 'user_id', 'cv', 'carta_presentacion',
        'estado', 'nota_prueba', 'observaciones', 'fecha_entrevista',
    ];

    protected function casts(): array
    {
        return [
            'fecha_entrevista' => 'datetime',
            'nota_prueba' => 'decimal:2',
        ];
    }

    public function oferta() { return $this->belongsTo(Oferta::class); }
    public function candidato() { return $this->belongsTo(User::class, 'user_id'); }
    public function perfil() { return $this->hasOneThrough(PerfilCandidato::class, User::class, 'id', 'user_id', 'user_id', 'id'); }
}
