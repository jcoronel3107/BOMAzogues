<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIntegrantesGuardiaToEstacionNovedadesTable extends Migration
{
    public function up()
    {
        Schema::table('estacion_novedades', function (Blueprint $table) {
            if (!Schema::hasColumn('estacion_novedades', 'integrantes_guardia')) {
                $table->json('integrantes_guardia')->nullable();
            }
        });
    }

    public function down()
    {
        Schema::table('estacion_novedades', function (Blueprint $table) {
            $table->dropColumn('integrantes_guardia');
        });
    }
}