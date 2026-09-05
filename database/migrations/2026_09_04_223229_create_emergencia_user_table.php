<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmergenciaUserTable extends Migration
{
    public function up()
    {
        Schema::create('emergencia_user', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('emergencia_id');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();
            
            $table->foreign('emergencia_id')->references('id')->on('emergencias')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('emergencia_user');
    }
}