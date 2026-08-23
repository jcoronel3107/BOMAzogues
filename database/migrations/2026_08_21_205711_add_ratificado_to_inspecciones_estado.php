<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRatificadoToInspeccionesEstado extends Migration
{
    public function up()
    {
        Schema::table('inspeccions', function (Blueprint $table) {
            // Modificar el enum para agregar 'ratificado'
            DB::statement("ALTER TABLE inspeccions MODIFY estado ENUM('pendiente', 'en_progreso', 'completada', 'aprobada', 'rechazada', 'ratificado') NOT NULL DEFAULT 'pendiente'");
        });
    }

    public function down()
    {
        Schema::table('inspeccions', function (Blueprint $table) {
            DB::statement("ALTER TABLE inspeccions MODIFY estado ENUM('pendiente', 'en_progreso', 'completada', 'aprobada', 'rechazada') NOT NULL DEFAULT 'pendiente'");
        });
    }
}