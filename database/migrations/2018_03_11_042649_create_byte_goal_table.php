<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateByteGoalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('byte_goal', function (Blueprint $table) {
            $table->integer('byte_id')->unsigned()->index();
            $table->foreign('byte_id')->references('id')->on('bytes')->onDelete('cascade');

            $table->integer('goal_id')->unsigned()->index();
            $table->foreign('goal_id')->references('id')->on('goals')->onDelete('cascade');

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
        Schema::dropIfExists('byte_goal');
        if(env('DB_CONNECTION') == "mysql")
        {
            DB::statement('SET FOREIGN_KEY_CHECKS = 1');
        }
    }
}
