<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmergenciaFuegoPersonalTable extends Migration
{
    public function up()
    {
        Schema::create('emergencia_fuego_personal', function (Blueprint $table) {
            $table->id();
            $table->foreignId('emergencia_fuego_id')
                  ->constrained('emergencias_fuego')
                  ->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users');
            $table->string('rol_en_emergencia', 50);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('emergencia_fuego_personal');
    }
}