<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('alquileres', function (Blueprint $table) {
            $table->enum('estado', ['Pendiente', 'Aceptado', 'Denegado'])->default('Pendiente')->after('devuelto');
        });
    }

    public function down(): void
    {
        Schema::table('alquileres', function (Blueprint $table) {
            $table->dropColumn('estado');
        });
    }
};
