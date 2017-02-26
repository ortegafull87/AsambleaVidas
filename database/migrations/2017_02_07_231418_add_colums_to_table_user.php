<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumsToTableUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->text('last_name');
            $table->string('image');
            $table->integer('age');
            $table->text('contry_code');
            $table->enum('gandle',['M','F']);
            $table->integer('id_profile')->unsigned()->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('last_name');
            $table->dropColumn('image');
            $table->dropColumn('age');
            $table->dropColumn('contry_code');
            $table->dropColumn('gandle');
            $table->dropColumn('id_profile');
        });
    }
}
