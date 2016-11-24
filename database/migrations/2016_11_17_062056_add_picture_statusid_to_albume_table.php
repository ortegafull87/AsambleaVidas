<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPictureStatusidToAlbumeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('albumes', function (Blueprint $table) {
            $table->string('picture');
            $table->integer('status_id')->unsigned()->default(1);
        });

        Schema::table('albumes',function($table){
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
        Schema::table('albumes', function (Blueprint $table) {
            $table->dropColumn('picture');
            $table->dropColumn('status_id');
        });

        Schema::table('albumes',function($table){
            $table->dropForeign(['user_id']);
        });
    }
}
