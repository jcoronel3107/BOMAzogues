<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEstacionEmergenciasTable extends Migration
{
    public function up()
    {
        Schema::create('estacion_emergencias', function (Blueprint $table) {
            $table->id();
            $table->foreignId('estacion_novedad_id')->constrained('estacion_novedades')->onDelete('cascade');
            $table->string('tipo_emergencia');
            $table->string('lugar');
            $table->string('direccion')->nullable();
            $table->string('sector')->nullable();
            $table->time('hora_ingreso');
            $table->time('hora_salida')->nullable();
            $table->integer('numero_afectados')->default(0);
            $table->integer('numero_vehiculos')->default(0);
            $table->integer('numero_bomberos')->default(0);
            $table->text('descripcion')->nullable();
            $table->text('recursos_utilizados')->nullable();
            $table->text('observaciones')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('estacion_emergencias');
    }
}