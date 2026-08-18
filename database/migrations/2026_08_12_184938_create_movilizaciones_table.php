<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMovilizacionesTable extends Migration
{
    public function up()
    {
        Schema::create('movilizaciones', function (Blueprint $table) {
            $table->id();
            
            // Datos principales
            $table->date('fecha');
            $table->time('hora_salida');
            $table->string('motivo');
            $table->string('lugar_origen');
            $table->string('destino');
            $table->time('hora_llegada')->nullable();
            
            // Tiempo de duración
            $table->integer('tiempo_duracion')->nullable();
            
            // Conductor
            $table->string('conductor_nombres');
            $table->string('conductor_cedula');
            $table->string('conductor_cargo')->nullable();
            
            // Vehículo
            $table->string('vehiculo_marca');
            $table->string('vehiculo_placa');
            $table->integer('vehiculo_km_salida');
            $table->integer('vehiculo_km_llegada')->nullable();
            $table->integer('vehiculo_km_recorrido')->nullable();
            
            // Listado de integrantes (JSON)
            $table->json('integrantes')->nullable();
            
            // Estado
            $table->enum('estado', ['pendiente', 'aprobado', 'rechazado', 'finalizado'])->default('pendiente');
            
            // Autorización
            $table->foreignId('usuario_crea_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('usuario_autoriza_id')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('fecha_autorizacion')->nullable();
            $table->text('observaciones')->nullable();
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('movilizaciones');
    }
}