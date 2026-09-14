<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmergenciasPrehospitalariasTable extends Migration
{
    public function up()
    {
        Schema::create('emergencias_prehospitalarias', function (Blueprint $table) {
            $table->id();
            $table->string('codigo', 30)->unique(); // Ej: EP-2025-0001
            $table->dateTime('fecha_salida');
            $table->dateTime('fecha_llegada_sitio')->nullable();
            $table->dateTime('fecha_salida_sitio')->nullable();
            $table->dateTime('fecha_llegada_base')->nullable();
            $table->string('direccion', 255);
            $table->string('referencia', 255)->nullable();
            $table->string('motivo_llamado', 255);
            $table->enum('tipo_emergencia', [
                'Accidente de tránsito', 'Emergencia médica', 'Trauma',
                'Obstétrica', 'Pediatrica', 'Psiquiatrica', 'Otra'
            ]);
            $table->enum('prioridad', ['Rojo', 'Naranja', 'Amarillo', 'Verde', 'Azul'])
                ->default('Amarillo');
            $table->foreignId('vehiculo_id')->constrained('vehiculos');
            $table->foreignId('usuario_registra_id')->constrained('users');
            $table->text('observaciones_generales')->nullable();
            $table->enum('estado', [
                'En curso', 'Finalizada', 'Cancelada', 'Derivada'
            ])->default('En curso');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('emergencias_prehospitalarias');
    }
}
