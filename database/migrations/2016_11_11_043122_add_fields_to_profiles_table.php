<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('profiles', function (Blueprint $table) {
            $table->string('firstName');
            $table->string('lastName');
            $table->string('nikName');
            $table->integer('complete')->default(0);
            $table->integer('city_id');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('profiles', function (Blueprint $table) {
            $table->dropColumn('firstName');
            $table->dropColumn('lastName');
            $table->dropColumn('nikName');
            $table->dropColumn('complete');
            $table->dropColumn('birthday');
            $table->dropColumn('city_id');
        });
    }
}
