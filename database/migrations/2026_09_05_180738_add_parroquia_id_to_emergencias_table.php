<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddParroquiaIdToEmergenciasTable extends Migration
{
    public function up()
    {
        Schema::table('emergencias', function (Blueprint $table) {
            if (!Schema::hasColumn('emergencias', 'parroquia_id')) {
                $table->unsignedBigInteger('parroquia_id')->nullable()->after('estacion_id');
                $table->foreign('parroquia_id')->references('id')->on('parroquias')->onDelete('set null');
            }
        });
    }

    public function down()
    {
        Schema::table('emergencias', function (Blueprint $table) {
            $table->dropForeign(['parroquia_id']);
            $table->dropColumn('parroquia_id');
        });
    }
}