<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePacientesEmergenciaFuegoTable extends Migration
{
    public function up()
    {
        Schema::create('pacientes_emergencia_fuego', function (Blueprint $table) {
            $table->id();
            $table->foreignId('emergencia_fuego_id')
                  ->constrained('emergencias_fuego')
                  ->onDelete('cascade');

            // Datos básicos
            $table->string('nombre_completo', 150);
            $table->integer('edad')->nullable();
            $table->enum('sexo', ['M', 'F', 'Indefinido'])->default('Indefinido');
            $table->string('cedula', 20)->nullable();
            $table->string('telefono', 20)->nullable();

            // Condición
            $table->enum('condicion', ['Ileso', 'Herido', 'Fallecido', 'Desconocido'])
                  ->default('Ileso');
            $table->string('tipo_lesion', 150)->nullable();
            $table->string('hospital_destino', 150)->nullable();

            // Signos vitales (opcional, si está herido)
            $table->integer('frecuencia_cardiaca')->nullable();
            $table->integer('frecuencia_respiratoria')->nullable();
            $table->integer('saturacion_oxigeno')->nullable();
            $table->decimal('temperatura', 4, 1)->nullable();

            $table->text('observaciones')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pacientes_emergencia_fuego');
    }
}