<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTracksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tracks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            //$table->integer('duration');
            $table->string('file');
            $table->timestamps();
            $table->integer('author_id')->unsigned();
            $table->integer('albume_id')->unsigned();
        });

        Schema::table('tracks',function($table){
            $table->foreign('author_id')->references('id')->on('authors');
            $table->foreign('albume_id')->references('id')->on('albumes');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('tracks');
    }
}
