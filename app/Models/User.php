<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'role', 'telefono', 'ciudad', 'activo',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'activo' => 'boolean',
        ];
    }

    public function isAdmin(): bool { return $this->role === 'admin'; }
    public function isEmpresa(): bool { return $this->role === 'empresa'; }
    public function isCandidato(): bool { return $this->role === 'candidato'; }

    public function empresa() { return $this->hasOne(Empresa::class); }
    public function perfil() { return $this->hasOne(PerfilCandidato::class); }
    public function postulaciones() { return $this->hasMany(Postulacion::class); }
}
