<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostStudyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('post_study', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('post_study_parent_id');
            $table->integer('study_id')->unsigned()->unsigned();
            $table->integer('user_id')->unsigned();
            $table->integer('status_id')->unsigned();
            $table->timestamps();
        });
        
        Schema::table('post_study', function (Blueprint $table) {
            $table->foreign('study_id')->references('id')->on('studys');
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
        Schema::drop('post_study');
    }
}
