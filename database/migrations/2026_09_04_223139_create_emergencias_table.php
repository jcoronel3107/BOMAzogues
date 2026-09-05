<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmergenciasTable extends Migration
{
    public function up()
    {
        Schema::create('emergencias', function (Blueprint $table) {
            $table->id();
            
            // Pestaña 1: Información Emergencia
            $table->date('fecha');
            $table->text('informacion_inicial');
            $table->unsignedBigInteger('tipo_incidente_id');
            $table->string('subcategoria')->nullable();
            $table->unsignedBigInteger('estacion_id');
            $table->time('hora_salida_emergencia');
            $table->time('hora_llegada_emergencia');
            $table->time('hora_en_base');
            $table->text('detalle_emergencia');
            $table->string('ciudadano_afectado')->nullable();
            $table->string('danos_estimados')->nullable();
            
            // Campos de control
            $table->string('usr_creador');
            $table->string('usr_editor')->nullable();
            
            $table->timestamps();
            $table->softDeletes();
            
            // Llaves foráneas
            $table->foreign('tipo_incidente_id')->references('id')->on('incidentes')->onDelete('cascade');
            $table->foreign('estacion_id')->references('id')->on('stations')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('emergencias');
    }
}