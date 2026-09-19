<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmergenciaFuegoVehiculosTable extends Migration
{
    public function up()
    {
        Schema::create('emergencia_fuego_vehiculos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('emergencia_fuego_id')
                  ->constrained('emergencias_fuego')
                  ->onDelete('cascade');
            $table->foreignId('vehiculo_id')->constrained('vehiculos');
            $table->string('rol_en_emergencia', 50)->nullable(); // Bomberos, Cisterna, Rescate
            $table->integer('km_salida')->nullable();
            $table->integer('km_llegada')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('emergencia_fuego_vehiculos');
    }
}