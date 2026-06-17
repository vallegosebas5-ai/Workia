<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PerfilCandidato extends Model
{
    protected $table = 'perfiles_candidato';
    protected $fillable = [
        'user_id', 'foto', 'fecha_nacimiento', 'direccion', 'ciudad',
        'resumen_profesional', 'nivel_educacion', 'carrera', 'cv',
    ];

    public function user() { return $this->belongsTo(User::class); }
}
