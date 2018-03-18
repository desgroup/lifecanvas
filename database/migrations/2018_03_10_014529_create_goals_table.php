<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGoalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('goals', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('asset_id')->nullable();
            $table->integer('place_id')->nullable();
            $table->integer('person_id')->nullable();
            $table->tinyInteger('privacy')->default('0');
            $table->integer('user_id');
            $table->timestamps();
        });

        Schema::create('goal_lifelist', function (Blueprint $table) {
            $table->integer('goal_id')->unsigned()->index();
            $table->foreign('goal_id')->references('id')->on('goals')->onDelete('cascade');

            $table->integer('lifelist_id')->unsigned()->index();
            $table->foreign('lifelist_id')->references('id')->on('lifelists')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if(env('DB_CONNECTION') == "mysql")
        {
            DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        }
        Schema::dropIfExists('goals');
        Schema::dropIfExists('goal_lifelist');
        if(env('DB_CONNECTION') == "mysql")
        {
            DB::statement('SET FOREIGN_KEY_CHECKS = 1');
        }
    }
}
