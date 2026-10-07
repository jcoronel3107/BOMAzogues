<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEstacionNovedadEmergenciasTable extends Migration
{
    public function up()
    {
        Schema::create('estacion_novedad_emergencias', function (Blueprint $table) {
            $table->id();
            $table->foreignId('estacion_novedad_id')
                  ->constrained('estacion_novedades')
                  ->onDelete('cascade');
            $table->foreignId('emergencia_id')
                  ->constrained('emergencias')
                  ->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('estacion_novedad_emergencias');
    }
}