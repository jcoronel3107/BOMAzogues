<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEstacionPersonalTable  extends Migration
{
    public function up()
    {
        Schema::create('estacion_personal', function (Blueprint $table) {
            $table->id();
            
            $table->foreignId('estacion_novedad_id')->constrained('estacion_novedades')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            
            // Datos del personal
            $table->string('cargo');
            $table->string('turno'); // mañana, tarde, noche, descanso
            $table->time('hora_entrada')->nullable();
            $table->time('hora_salida')->nullable();
            
            // Novedades del personal
            $table->enum('estado', ['presente', 'ausente', 'permiso', 'licencia', 'comision'])->default('presente');
            $table->text('observaciones')->nullable();
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('novedades_personal');
    }
}