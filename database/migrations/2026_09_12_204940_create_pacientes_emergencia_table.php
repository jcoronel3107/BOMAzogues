<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePacientesEmergenciaTable extends Migration
{
    public function up()
    {
        Schema::create('pacientes_emergencia', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('emergencia_prehospitalaria_id');
            $table->string('nombre_completo', 150);
            $table->integer('edad');
            $table->string('sexo', 20);
            $table->string('cedula', 20)->nullable();
            $table->string('telefono', 20)->nullable();
            $table->integer('frecuencia_cardiaca')->nullable();
            $table->integer('frecuencia_respiratoria')->nullable();
            $table->integer('saturacion_oxigeno')->nullable();
            $table->decimal('temperatura', 4, 1)->nullable();
            $table->integer('presion_sistolica')->nullable();
            $table->integer('presion_diastolica')->nullable();
            $table->integer('glasgow')->nullable();
            $table->text('motivo_atencion')->nullable();
            $table->text('evaluacion')->nullable();
            $table->text('procedimientos_realizados')->nullable();
            $table->text('observaciones')->nullable();
            $table->string('condicion', 30)->default('Estable');
            $table->string('destino', 100)->nullable();
            $table->string('hospital_destino', 150)->nullable();
            $table->timestamps();

            $table->foreign('emergencia_prehospitalaria_id')
                  ->references('id')
                  ->on('emergencias_prehospitalarias')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('pacientes_emergencia');
    }
}