<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmergenciaFuegoInsumosTable extends Migration
{
    public function up()
    {
        Schema::create('emergencia_fuego_insumos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('emergencia_fuego_id')
                  ->constrained('emergencias_fuego')
                  ->onDelete('cascade');
            $table->foreignId('insumo_medico_id')->constrained('insumos_medicos');
            $table->decimal('cantidad', 10, 2);
            $table->text('observaciones')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('emergencia_fuego_insumos');
    }
}