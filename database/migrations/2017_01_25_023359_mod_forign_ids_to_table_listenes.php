<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModForignIdsToTableListenes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('listeneds', function (Blueprint $table) {
            $table->foreign('track_id')->references('id')->on('tracks');
            $table->dropForeign(['user_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('listeneds', function (Blueprint $table) {
            $table->dropForeign(['track_id']);
            $table->foreign('user_id')->references('id')->on('users');
        });
    }
}
