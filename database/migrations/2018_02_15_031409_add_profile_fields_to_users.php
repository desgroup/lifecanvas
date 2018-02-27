<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddProfileFieldsToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function($table) {
            $table->date('birthdate')->after('password')->nullable();
            $table->string('first_name')->after('birthdate')->nullable();
            $table->string('last_name')->after('first_name')->nullable();
            $table->tinyInteger('privacy')->after('last_name')->default('1');
            $table->string('avatar')->after('privacy')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function($table) {
            $table->dropColumn('birthdate');
            $table->dropColumn('first_name');
            $table->dropColumn('last_name');
            $table->dropColumn('privacy');
            $table->dropColumn('avatar');
        });
    }
}
