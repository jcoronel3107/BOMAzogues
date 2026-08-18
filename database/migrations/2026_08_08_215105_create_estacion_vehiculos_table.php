<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEstacionVehiculosTable extends Migration
{
    public function up()
    {
        Schema::create('estacion_vehiculos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('estacion_novedad_id')->constrained('estacion_novedades')->onDelete('cascade');
            $table->foreignId('vehiculo_id')->constrained('vehiculos')->onDelete('cascade');
            $table->enum('estado', ['operativo', 'mantenimiento', 'averiado', 'fuera_servicio'])->default('operativo');
            $table->string('tipo_novedad');
            $table->text('descripcion')->nullable();
            $table->text('acciones_tomadas')->nullable();
            $table->integer('kilometraje')->nullable();
            $table->date('fecha_reporte');
            $table->date('fecha_solucion')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('estacion_vehiculos');
    }
}