<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEstacionNovedadFuegoTable extends Migration
{
    public function up()
    {
        Schema::create('estacion_novedad_fuego', function (Blueprint $table) {
            $table->id();
            $table->foreignId('estacion_novedad_id')
                  ->constrained('estacion_novedades')
                  ->onDelete('cascade');
            $table->foreignId('emergencia_fuego_id')
                  ->constrained('emergencias_fuego')
                  ->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('estacion_novedad_fuego');
    }
}