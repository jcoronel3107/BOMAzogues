<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmergenciaArchivosTable extends Migration
{
    public function up()
    {
        Schema::create('emergencia_archivos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('emergencia_prehospitalaria_id');
            $table->string('nombre_original', 255);
            $table->string('nombre_archivo', 255);
            $table->string('ruta', 500);
            $table->string('tipo', 50)->nullable();      // image, pdf, doc, etc.
            $table->string('mime_type', 100)->nullable();
            $table->unsignedBigInteger('tamano')->nullable(); // bytes
            $table->string('descripcion', 255)->nullable();
            $table->unsignedBigInteger('usuario_subio_id')->nullable();
            $table->timestamps();

            $table->foreign('emergencia_prehospitalaria_id')
                  ->references('id')
                  ->on('emergencias_prehospitalarias')
                  ->onDelete('cascade');

            $table->foreign('usuario_subio_id')
                  ->references('id')
                  ->on('users');
        });
    }

    public function down()
    {
        Schema::dropIfExists('emergencia_archivos');
    }
}