<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStationIdToUsersTable extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'station_id')) {
                $table->foreignId('station_id')
                    ->nullable()
                    ->constrained('stations')
                    ->onDelete('set null');
            }
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['station_id']);
            $table->dropColumn('station_id');
        });
    }
}