<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEstadoToEmergenciasTable extends Migration
{
    public function up()
    {
        Schema::table('emergencias', function (Blueprint $table) {
            if (!Schema::hasColumn('emergencias', 'estado')) {
                $table->enum('estado', ['activo', 'finalizado'])->default('activo');
            }
            if (!Schema::hasColumn('emergencias', 'fecha_finalizacion')) {
                $table->timestamp('fecha_finalizacion')->nullable();
            }
            if (!Schema::hasColumn('emergencias', 'usuario_finaliza_id')) {
                $table->foreignId('usuario_finaliza_id')->nullable()->constrained('users')->onDelete('set null');
            }
        });
    }

    public function down()
    {
        Schema::table('emergencias', function (Blueprint $table) {
            $table->dropColumn(['estado', 'fecha_finalizacion', 'usuario_finaliza_id']);
        });
    }
}