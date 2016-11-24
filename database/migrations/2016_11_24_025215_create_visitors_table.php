<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVisitorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('visitors', function (Blueprint $table) {
            $table->increments('id');
            $table->ipAddress('ip');
            $table->string('carrier');
            $table->double('lat');
            $table->double('lng');
            $table->integer('status_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->timestamps();
        });
        
        Schema::table('visitors',function($table){
            $table->foreign('status_id')->references('id')->on('status');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('visitors');
        
    }
}
