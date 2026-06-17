<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ofertas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('empresa_id')->constrained('empresas')->onDelete('cascade');
            $table->foreignId('categoria_id')->constrained('categorias')->onDelete('restrict');
            $table->string('titulo');
            $table->text('descripcion');
            $table->text('requisitos')->nullable();
            $table->string('ubicacion', 150)->nullable();
            $table->decimal('salario_min', 10, 2)->nullable();
            $table->decimal('salario_max', 10, 2)->nullable();
            $table->enum('tipo_contrato', ['tiempo_completo', 'medio_tiempo', 'freelance', 'practicante', 'temporal'])->default('tiempo_completo');
            $table->enum('modalidad', ['presencial', 'remoto', 'hibrido'])->default('presencial');
            $table->date('fecha_limite')->nullable();
            $table->enum('estado', ['activa', 'pausada', 'cerrada'])->default('activa');
            $table->integer('vacantes')->default(1);
            $table->boolean('requiere_cv')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ofertas');
    }
};
