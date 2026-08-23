<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddResponsablesToEstacionNovedadesTable extends Migration
{
    public function up()
    {
        Schema::table('estacion_novedades', function (Blueprint $table) {
            // Campos para el flujo de estados
            if (!Schema::hasColumn('estacion_novedades', 'usuario_crea_id')) {
                $table->foreignId('usuario_crea_id')->nullable()->constrained('users')->onDelete('set null');
            }
            if (!Schema::hasColumn('estacion_novedades', 'usuario_revisa_id')) {
                // Este campo ya existe, solo lo dejamos como referencia
                // pero agregamos los que faltan
            }
            if (!Schema::hasColumn('estacion_novedades', 'usuario_aprueba_id')) {
                // Este campo ya existe
            }
            if (!Schema::hasColumn('estacion_novedades', 'usuario_ratifica_id')) {
                $table->foreignId('usuario_ratifica_id')->nullable()->constrained('users')->onDelete('set null');
            }
            if (!Schema::hasColumn('estacion_novedades', 'fecha_creacion')) {
                $table->timestamp('fecha_creacion')->nullable();
            }
            if (!Schema::hasColumn('estacion_novedades', 'fecha_revision')) {
                // Este campo ya existe (fecha_revision)
            }
            if (!Schema::hasColumn('estacion_novedades', 'fecha_aprobacion')) {
                // Este campo ya existe (fecha_aprobacion)
            }
            if (!Schema::hasColumn('estacion_novedades', 'fecha_ratificacion')) {
                $table->timestamp('fecha_ratificacion')->nullable();
            }
        });
    }

    public function down()
    {
        Schema::table('estacion_novedades', function (Blueprint $table) {
            $table->dropForeign(['usuario_crea_id']);
            $table->dropForeign(['usuario_ratifica_id']);
            $table->dropColumn([
                'usuario_crea_id',
                'usuario_ratifica_id',
                'fecha_creacion',
                'fecha_ratificacion'
            ]);
        });
    }
}