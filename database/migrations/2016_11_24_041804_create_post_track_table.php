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
            $table->integer('post_track_parent_id');
            $table->integer('track_id')->unsigned();
            $table->integer('post_id')->unsigned();
        });
        
        Schema::table('post_track', function ($table) {
            $table->foreign('track_id')->references('id')->on('tracks');
            $table->foreign('post_id')->references('id')->on('posts');
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
