<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmergenciaVehiculoTable extends Migration
{
    public function up()
    {
        Schema::create('emergencia_vehiculo', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('emergencia_id');
            $table->unsignedBigInteger('vehiculo_id');
            $table->unsignedBigInteger('conductor_id')->nullable();
            $table->integer('km_salida')->nullable();
            $table->integer('km_retorno')->nullable();
            $table->timestamps();
            
            $table->foreign('emergencia_id')->references('id')->on('emergencias')->onDelete('cascade');
            $table->foreign('vehiculo_id')->references('id')->on('vehiculos')->onDelete('cascade');
            $table->foreign('conductor_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('emergencia_vehiculo');
    }
}