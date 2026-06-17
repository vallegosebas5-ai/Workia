<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('postulaciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('oferta_id')->constrained('ofertas')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('cv')->nullable();
            $table->text('carta_presentacion')->nullable();
            $table->enum('estado', ['pendiente', 'revision', 'prueba', 'entrevista', 'aceptado', 'rechazado'])->default('pendiente');
            $table->decimal('nota_prueba', 5, 2)->nullable();
            $table->text('observaciones')->nullable();
            $table->timestamp('fecha_entrevista')->nullable();
            $table->unique(['oferta_id', 'user_id']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('postulaciones');
    }
};
