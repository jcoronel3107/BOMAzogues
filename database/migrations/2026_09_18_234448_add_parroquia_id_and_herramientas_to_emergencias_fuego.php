<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddParroquiaIdAndHerramientasToEmergenciasFuego extends Migration
{
    public function up()
    {
        // 1. Agregar parroquia_id a emergencias_fuego
        Schema::table('emergencias_fuego', function (Blueprint $table) {
            $table->unsignedBigInteger('parroquia_id')->nullable()->after('sector');
            $table->foreign('parroquia_id')->references('id')->on('parroquias');
        });

        // 2. Crear tabla pivote de herramientas
        Schema::create('emergencia_fuego_herramientas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('emergencia_fuego_id')
                  ->constrained('emergencias_fuego')
                  ->onDelete('cascade');
            $table->foreignId('herramienta_id')->constrained('herramientas');
            $table->integer('cantidad')->default(1);
            $table->text('observaciones')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('emergencia_fuego_herramientas');

        Schema::table('emergencias_fuego', function (Blueprint $table) {
            $table->dropForeign(['parroquia_id']);
            $table->dropColumn('parroquia_id');
        });
    }
}