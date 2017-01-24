<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveForeingKeyUseridToTableRatingTrack extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rating_track', function (Blueprint $table) {
            $table->integer('visitor_id')->unsigned();
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
        Schema::table('rating_track', function (Blueprint $table) {
            $table->addColumn('visitor_id');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }
}
