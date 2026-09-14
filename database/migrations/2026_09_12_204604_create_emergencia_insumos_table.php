<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmergenciaInsumosTable extends Migration
{
    public function up()
    {
        Schema::create('emergencia_insumos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('emergencia_prehospitalaria_id');
            $table->unsignedBigInteger('insumo_medico_id');
            $table->integer('cantidad');
            $table->text('observaciones')->nullable();
            $table->timestamps();

            $table->foreign('emergencia_prehospitalaria_id')
                  ->references('id')
                  ->on('emergencias_prehospitalarias')
                  ->onDelete('cascade');
            $table->foreign('insumo_medico_id')
                  ->references('id')
                  ->on('insumos_medicos');
        });
    }

    public function down()
    {
        Schema::dropIfExists('emergencia_insumos');
    }
}