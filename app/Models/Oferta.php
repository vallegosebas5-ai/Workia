<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Oferta extends Model
{
    protected $fillable = [
        'empresa_id', 'categoria_id', 'titulo', 'descripcion', 'requisitos',
        'ubicacion', 'salario_min', 'salario_max', 'tipo_contrato', 'modalidad',
        'fecha_limite', 'estado', 'vacantes', 'requiere_cv',
    ];

    protected function casts(): array
    {
        return [
            'fecha_limite' => 'date',
            'requiere_cv' => 'boolean',
            'salario_min' => 'decimal:2',
            'salario_max' => 'decimal:2',
        ];
    }

    public function empresa() { return $this->belongsTo(Empresa::class); }
    public function categoria() { return $this->belongsTo(Categoria::class); }
    public function postulaciones() { return $this->hasMany(Postulacion::class); }
    public function prueba() { return $this->hasOne(Prueba::class); }
}
