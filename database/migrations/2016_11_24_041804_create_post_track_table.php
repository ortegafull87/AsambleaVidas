<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostTrackTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){
        
        Schema::create('post_track', function (Blueprint $table) {
            $table->increments('id');
            $table->longText('comment');
            $table->integer('post_track_parent_id');
            $table->integer('track_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->integer('status_id')->unsigned();
            $table->timestamps();
        });
        
        Schema::table('post_track', function ($table) {
            $table->foreign('track_id')->references('id')->on('tracks');
            $table->foreign('user_id')->references('id')->on('users');
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
        Schema::drop('post_track');
    }
}
