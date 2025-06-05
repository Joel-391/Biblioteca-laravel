<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();  // ID autoincremental
            $table->string('nombre_rol', 50); // Nombre del rol
            $table->text('descripcion')->nullable(); // Descripción opcional
            $table->integer('nivel_prioridad'); // Prioridad del rol
            $table->boolean('activo')->default(true); // Estado activo/inactivo
            $table->timestamps(); // Campos created_at y updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roles');
    }
};

