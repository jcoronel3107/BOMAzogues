<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInsumosMedicosTable extends Migration
{
    public function up()
    {
        Schema::create('insumos_medicos', function (Blueprint $table) {
            $table->id();
            
            // Campos principales
            $table->string('codigo')->unique();
            $table->string('descripcion');
            $table->string('caso_uso');
            $table->integer('cantidad')->default(0);
            $table->integer('cantidad_minima')->default(5)->comment('Cantidad mínima para alerta');
            
            // Datos adicionales
            $table->string('categoria')->nullable();
            $table->string('presentacion')->nullable(); // unidad, caja, frasco, etc.
            $table->date('fecha_vencimiento')->nullable();
            $table->string('ubicacion')->nullable();
            $table->text('observaciones')->nullable();
            
            // Estado
            $table->enum('estado', ['disponible', 'agotado', 'vencido'])->default('disponible');
            
            // Auditoría
            $table->foreignId('usuario_crea_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('usuario_edita_id')->nullable()->constrained('users')->onDelete('set null');
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('insumos_medicos');
    }
}