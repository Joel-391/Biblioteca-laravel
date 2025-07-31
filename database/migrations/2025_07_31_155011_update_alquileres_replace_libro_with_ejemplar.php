<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateAlquileresReplaceLibroWithEjemplar extends Migration
{
    public function up()
    {
        Schema::table('alquileres', function (Blueprint $table) {
            // Eliminar la clave foránea y columna libro_id
            $table->dropForeign(['libro_id']);
            $table->dropColumn('libro_id');

            // Agregar la nueva columna ejemplar_id
            $table->unsignedBigInteger('ejemplar_id');

            // Crear relación con la tabla ejemplares
            $table->foreign('ejemplar_id')->references('id')->on('ejemplares')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('alquileres', function (Blueprint $table) {
            // Eliminar la clave foránea y columna ejemplar_id
            $table->dropForeign(['ejemplar_id']);
            $table->dropColumn('ejemplar_id');

            // Restaurar la columna libro_id
            $table->unsignedBigInteger('libro_id');
            $table->foreign('libro_id')->references('id')->on('libros')->onDelete('cascade');
        });
    }
}
