<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablePlaylistTrack extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('playlist_track', function (Blueprint $table) {
            $table->integer('playlist_id')->unsigned();
            $table->integer('track_id')->unsigned();
            $table->integer('status_id')->unsigned();
            $table->timestamps();
        });

        Schema::table('playlist_track', function (Blueprint $table) {
            $table->foreign('playlist_id')->references('id')->on('playlists');
            $table->foreign('track_id')->references('id')->on('tracks');
            $table->foreign('status_id')->references('id')->on('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('playlist_track');
    }
}
