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
            $table->integer('post_id')->unsigned()->unsigned();
            $table->timestamps();
        });
        
        Schema::table('post_study', function (Blueprint $table) {
            $table->foreign('study_id')->references('id')->on('studys');
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
        Schema::drop('post_study');
    }
}
