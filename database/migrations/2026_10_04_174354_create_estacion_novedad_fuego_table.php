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
            
            $table->unsignedBigInteger('estacion_novedad_id');
            $table->unsignedBigInteger('emergencia_fuego_id');
            
            $table->foreign('estacion_novedad_id', 'fk_nov_fuego_novedad')
                  ->references('id')
                  ->on('estacion_novedades')
                  ->onDelete('cascade');
                  
            $table->foreign('emergencia_fuego_id', 'fk_nov_fuego_emergencia')
                  ->references('id')
                  ->on('emergencias_fuego')
                  ->onDelete('cascade');
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('estacion_novedad_fuego');
    }
}