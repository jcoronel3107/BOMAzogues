<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDireccionReferenciaToEmergencias extends Migration
{
    public function up()
    {
        Schema::table('emergencias', function (Blueprint $table) {
            $table->string('direccion', 255)->nullable()->after('parroquia_id');
            $table->string('referencia', 255)->nullable()->after('direccion');
        });
    }

    public function down()
    {
        Schema::table('emergencias', function (Blueprint $table) {
            $table->dropColumn(['direccion', 'referencia']);
        });
    }
}