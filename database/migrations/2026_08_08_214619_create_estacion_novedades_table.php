<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEstacionNovedadesTable extends Migration
{
    public function up()
    {
        Schema::create('estacion_novedades', function (Blueprint $table) {
            $table->id();
            $table->date('fecha');
            $table->foreignId('estacion_id')->constrained('stations')->onDelete('cascade');
            $table->foreignId('usuario_elabora_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('usuario_revisa_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('usuario_aprueba_id')->nullable()->constrained('users')->onDelete('set null');
            $table->enum('estado', ['elaboracion', 'revision', 'aprobado'])->default('elaboracion');
            $table->timestamp('fecha_elaboracion')->useCurrent();
            $table->timestamp('fecha_revision')->nullable();
            $table->timestamp('fecha_aprobacion')->nullable();
            $table->text('observaciones')->nullable();
            $table->boolean('bloqueado')->default(false);
            $table->timestamps();
            $table->softDeletes();
            $table->index(['fecha', 'estacion_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('estacion_novedades');
    }
}