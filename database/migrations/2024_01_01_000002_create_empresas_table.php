<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('empresas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('razon_social');
            $table->string('nit', 30)->nullable();
            $table->string('rubro', 150)->nullable();
            $table->text('descripcion')->nullable();
            $table->string('logo')->nullable();
            $table->string('sitio_web')->nullable();
            $table->string('direccion')->nullable();
            $table->string('ciudad', 100)->nullable();
            $table->string('telefono', 20)->nullable();
            $table->boolean('verificada')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('empresas');
    }
};
