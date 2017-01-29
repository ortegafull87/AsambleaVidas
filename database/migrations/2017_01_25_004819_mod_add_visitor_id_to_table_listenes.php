<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModAddVisitorIdToTableListenes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('listeneds', function (Blueprint $table) {
            $table->integer('visitor_id')->unsigned();
            $table->dropForeign(['track_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('listenes', function (Blueprint $table) {
            $table->dropColumn('visitor_id');
            $table->foreign('track_id')->references('id')->on('tracks');
        });
    }
}
