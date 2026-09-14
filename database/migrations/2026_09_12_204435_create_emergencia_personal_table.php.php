<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmergenciaPersonalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
                    Schema::create('emergencia_personal', function (Blueprint $table) {
                $table->id();
                $table->foreignId('emergencia_prehospitalaria_id')
                    ->constrained('emergencias_prehospitalarias')->onDelete('cascade');
                $table->foreignId('user_id')->constrained('users');
                $table->string('rol_en_emergencia', 50); // Conductor, Paramédico, Médico, etc.
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
        //
    }
}
