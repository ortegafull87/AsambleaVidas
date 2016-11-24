<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('studys', function (Blueprint $table) {
            $table->increments('id');
            $table->longText('text');
            $table->string('video_link');
            $table->integer('user_id')->unsigned();
            $table->integer('status_id')->unsigned();
            $table->timestamps();
        });        
        
        Schema::table('studys', function (Blueprint $table) {
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
        Schema::drop('studys');
    }
}
