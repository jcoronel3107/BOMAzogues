<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmergenciaFuegoArchivosTable extends Migration
{
    public function up()
    {
        Schema::create('emergencia_fuego_archivos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('emergencia_fuego_id')
                  ->constrained('emergencias_fuego')
                  ->onDelete('cascade');
            $table->string('nombre_original', 255);
            $table->string('nombre_archivo', 255);
            $table->string('ruta', 500);
            $table->string('tipo', 50)->nullable();
            $table->string('mime_type', 100)->nullable();
            $table->unsignedBigInteger('tamano')->nullable();
            $table->string('descripcion', 255)->nullable();
            $table->unsignedBigInteger('usuario_subio_id')->nullable();
            $table->timestamps();

            $table->foreign('usuario_subio_id')
                  ->references('id')
                  ->on('users');
        });
    }

    public function down()
    {
        Schema::dropIfExists('emergencia_fuego_archivos');
    }
}