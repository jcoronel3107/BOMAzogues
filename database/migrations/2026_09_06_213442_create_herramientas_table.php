<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHerramientasTable extends Migration
{
    public function up()
    {
        Schema::create('herramientas', function (Blueprint $table) {
            $table->id();
            
            // Campos principales
            $table->string('codigo')->unique();
            $table->string('descripcion');
            $table->string('ubicacion')->nullable();
            $table->integer('cantidad')->default(0);
            $table->integer('cantidad_minima')->default(1);
            
            // Datos adicionales
            $table->string('marca')->nullable();
            $table->string('modelo')->nullable();
            $table->string('numero_serie')->nullable();
            $table->string('categoria')->nullable(); // eléctrica, manual, medición, etc.
            $table->date('fecha_compra')->nullable();
            $table->decimal('valor_compra', 10, 2)->nullable();
            $table->date('fecha_mantenimiento')->nullable();
            $table->text('observaciones')->nullable();
            
            // Estado
            $table->enum('estado', [
                'disponible', 
                'en_uso', 
                'mantenimiento', 
                'averiada', 
                'baja'
            ])->default('disponible');
            
            // Auditoría
            $table->foreignId('usuario_crea_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('usuario_edita_id')->nullable()->constrained('users')->onDelete('set null');
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('herramientas');
    }
}