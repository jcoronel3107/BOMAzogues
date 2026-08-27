<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddResponsablesToInspeccionesTable extends Migration
{
    public function up()
    {
        Schema::table('inspeccions', function (Blueprint $table) {
            if (!Schema::hasColumn('inspeccions', 'usuario_crea_id')) {
                $table->foreignId('usuario_crea_id')->nullable()->constrained('users')->onDelete('set null');
            }
            if (!Schema::hasColumn('inspeccions', 'usuario_asigna_id')) {
                $table->foreignId('usuario_asigna_id')->nullable()->constrained('users')->onDelete('set null');
            }
            if (!Schema::hasColumn('inspeccions', 'usuario_aprueba_id')) {
                $table->foreignId('usuario_aprueba_id')->nullable()->constrained('users')->onDelete('set null');
            }
            if (!Schema::hasColumn('inspeccions', 'usuario_ratifica_id')) {
                $table->foreignId('usuario_ratifica_id')->nullable()->constrained('users')->onDelete('set null');
            }
            if (!Schema::hasColumn('inspeccions', 'fecha_asignacion')) {
                $table->timestamp('fecha_asignacion')->nullable();
            }
            if (!Schema::hasColumn('inspeccions', 'fecha_aprobacion')) {
                $table->timestamp('fecha_aprobacion')->nullable();
            }
            if (!Schema::hasColumn('inspeccions', 'fecha_ratificacion')) {
                $table->timestamp('fecha_ratificacion')->nullable();
            }
        });
    }

    public function down()
    {
        Schema::table('inspeccions', function (Blueprint $table) {
            $table->dropForeign(['usuario_crea_id']);
            $table->dropForeign(['usuario_asigna_id']);
            $table->dropForeign(['usuario_aprueba_id']);
            $table->dropForeign(['usuario_ratifica_id']);
            $table->dropColumn([
                'usuario_crea_id',
                'usuario_asigna_id',
                'usuario_aprueba_id',
                'usuario_ratifica_id',
                'fecha_asignacion',
                'fecha_aprobacion',
                'fecha_ratificacion'
            ]);
        });
    }
}