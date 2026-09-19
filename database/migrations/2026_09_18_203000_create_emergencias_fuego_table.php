<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmergenciasFuegoTable extends Migration
{
    public function up()
    {
        Schema::create('emergencias_fuego', function (Blueprint $table) {
            $table->id();
            $table->string('codigo', 30)->unique();

            // Tiempos
            $table->dateTime('fecha_salida');
            $table->dateTime('fecha_llegada_sitio')->nullable();
            $table->dateTime('fecha_control')->nullable();
            $table->dateTime('fecha_extincion')->nullable();
            $table->dateTime('fecha_llegada_base')->nullable();

            // Ubicación
            $table->string('direccion', 255);
            $table->string('referencia', 255)->nullable();
            $table->string('parroquia', 150)->nullable();
            $table->string('sector', 150)->nullable();

            // Detalles del incendio
            $table->string('motivo_llamado', 255);
            $table->enum('tipo_fuego', [
                'Estructural', 'Forestal', 'Vehicular', 'Basura',
                'Quimico', 'Industrial', 'Otro'
            ]);
            $table->enum('nivel_riesgo', ['Bajo', 'Medio', 'Alto', 'Crítico'])
                  ->default('Medio');
            $table->string('causa_probable', 150)->nullable();

            // Magnitud
            $table->decimal('area_afectada_m2', 10, 2)->nullable();
            $table->decimal('perdidas_estimadas', 12, 2)->nullable();
            $table->string('moneda', 10)->default('USD');

            // Recursos utilizados
            $table->decimal('agua_utilizada_litros', 10, 2)->nullable();
            $table->decimal('espuma_utilizada_litros', 10, 2)->nullable();
            $table->decimal('quimico_utilizado_litros', 10, 2)->nullable();

            // Víctimas
            $table->integer('victimas_ilesos')->default(0);
            $table->integer('victimas_heridos')->default(0);
            $table->integer('victimas_fallecidos')->default(0);

            // Apoyo
            $table->boolean('requirio_apoyo_externo')->default(false);
            $table->string('detalle_apoyo', 255)->nullable();

            // Registro
            $table->foreignId('usuario_registra_id')->constrained('users');
            $table->text('observaciones_generales')->nullable();
            $table->enum('estado', [
                'En curso', 'Controlado', 'Extinguido', 'En investigación', 'Finalizado'
            ])->default('En curso');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('emergencias_fuego');
    }
}