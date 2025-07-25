<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('ejemplares', function (Blueprint $table) {
            // agregamos un campo de texto nullable justo después de 'disponible'
            $table->text('nota')->nullable()->after('disponible');
        });
    }

    public function down()
    {
        Schema::table('ejemplares', function (Blueprint $table) {
            $table->dropColumn('nota');
        });
    }
};
