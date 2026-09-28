<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEstacionIdToEmergenciasPrehospitalariasAndFuego extends Migration
{
    public function up()
    {
        // Emergencias Prehospitalarias (solo si no existe)
        if (!Schema::hasColumn('emergencias_prehospitalarias', 'estacion_id')) {
            Schema::table('emergencias_prehospitalarias', function (Blueprint $table) {
                $table->unsignedBigInteger('estacion_id')->nullable()->after('vehiculo_id');
                $table->foreign('estacion_id')->references('id')->on('stations');
            });
        }

        // Emergencias de Fuego (solo si no existe)
        if (!Schema::hasColumn('emergencias_fuego', 'estacion_id')) {
            Schema::table('emergencias_fuego', function (Blueprint $table) {
                $table->unsignedBigInteger('estacion_id')->nullable()->after('sector');
                $table->foreign('estacion_id')->references('id')->on('stations');
            });
        }
    }

    public function down()
    {
        if (Schema::hasColumn('emergencias_prehospitalarias', 'estacion_id')) {
            Schema::table('emergencias_prehospitalarias', function (Blueprint $table) {
                $table->dropForeign(['estacion_id']);
                $table->dropColumn('estacion_id');
            });
        }

        if (Schema::hasColumn('emergencias_fuego', 'estacion_id')) {
            Schema::table('emergencias_fuego', function (Blueprint $table) {
                $table->dropForeign(['estacion_id']);
                $table->dropColumn('estacion_id');
            });
        }
    }
}