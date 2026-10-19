<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEstacionNovedadPrehospitalariasTable extends Migration
{
    public function up()
    {
        Schema::create('estacion_novedad_prehospitalarias', function (Blueprint $table) {
            $table->id();
            
            // Columnas
            $table->unsignedBigInteger('estacion_novedad_id');
            $table->unsignedBigInteger('emergencia_prehospitalaria_id');
            
            // Foreign keys con nombres cortos
            $table->foreign('estacion_novedad_id', 'fk_nov_preh_novedad')
                  ->references('id')
                  ->on('estacion_novedades')
                  ->onDelete('cascade');
                  
            $table->foreign('emergencia_prehospitalaria_id', 'fk_nov_preh_emergencia')
                  ->references('id')
                  ->on('emergencias_prehospitalarias')
                  ->onDelete('cascade');
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('estacion_novedad_prehospitalarias');
    }
}