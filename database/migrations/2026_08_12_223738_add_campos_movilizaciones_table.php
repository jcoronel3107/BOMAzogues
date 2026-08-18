<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCamposMovilizacionesTable extends Migration
{
    public function up()
    {
        Schema::table('movilizacions', function (Blueprint $table) {
            // Agregar campos que faltan
            if (!Schema::hasColumn('movilizacions', 'hora_salida')) {
                $table->time('hora_salida')->nullable();
            }
            
            if (!Schema::hasColumn('movilizacions', 'motivo')) {
                $table->string('motivo')->nullable();
            }
            
            if (!Schema::hasColumn('movilizacions', 'lugar_origen')) {
                $table->string('lugar_origen')->nullable();
            }
            
            if (!Schema::hasColumn('movilizacions', 'destino')) {
                $table->string('destino')->nullable();
            }
            
            if (!Schema::hasColumn('movilizacions', 'conductor_nombres')) {
                $table->string('conductor_nombres')->nullable();
            }
            
            if (!Schema::hasColumn('movilizacions', 'conductor_cedula')) {
                $table->string('conductor_cedula')->nullable();
            }
            
            if (!Schema::hasColumn('movilizacions', 'conductor_cargo')) {
                $table->string('conductor_cargo')->nullable();
            }
            
            if (!Schema::hasColumn('movilizacions', 'vehiculo_marca')) {
                $table->string('vehiculo_marca')->nullable();
            }
            
            if (!Schema::hasColumn('movilizacions', 'vehiculo_placa')) {
                $table->string('vehiculo_placa')->nullable();
            }
            
            if (!Schema::hasColumn('movilizacions', 'integrantes')) {
                $table->json('integrantes')->nullable();
            }
            
            if (!Schema::hasColumn('movilizacions', 'estado')) {
                $table->enum('estado', ['pendiente', 'aprobado', 'rechazado', 'finalizado'])->default('pendiente');
            }
            
            if (!Schema::hasColumn('movilizacions', 'usr_autoriza')) {
                $table->foreignId('usr_autoriza')->nullable()->constrained('users')->onDelete('set null');
            }
            
            if (!Schema::hasColumn('movilizacions', 'fecha_autorizacion')) {
                $table->timestamp('fecha_autorizacion')->nullable();
            }
        });
    }

    public function down()
    {
        Schema::table('movilizacions', function (Blueprint $table) {
            $table->dropColumn([
                'hora_salida',
                'motivo',
                'lugar_origen',
                'destino',
                'conductor_nombres',
                'conductor_cedula',
                'conductor_cargo',
                'vehiculo_marca',
                'vehiculo_placa',
                'integrantes',
                'estado',
                'usr_autoriza',
                'fecha_autorizacion'
            ]);
        });
    }
}