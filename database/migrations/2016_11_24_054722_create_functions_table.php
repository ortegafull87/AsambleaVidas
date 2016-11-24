<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFunctionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('functions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('function');
            $table->string('description');
            $table->integer('status_id')->unsigned()->default(3);
            $table->timestamps();
        });

        Schema::table('functions', function (Blueprint $table) {
            $table->foreign('status_id')->references('id')->on('status');
        });

        Schema::table('configurations', function (Blueprint $table) {
            $table->foreign('function_id')->references('id')->on('functions');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('functions');

        Schema::table('configurations', function (Blueprint $table) {
            $table->dropForeign(['function_id']);
        });
    }
}
