<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lines', function (Blueprint $table) {
            $table->increments('id');
            // The title for the lifeline
            $table->string('name');
            // TODO-KGW Need to figure out if I really want to have an icon for each line
            //$table->string('icon')->nullable();
            // User id for the owner of the lifeline
            $table->integer('user_id');
            $table->timestamps();
        });

        Schema::create('byte_line', function (Blueprint $table) {
            $table->integer('byte_id')->unsigned()->index();
            $table->foreign('byte_id')->references('id')->on('bytes')->onDelete('cascade');

            $table->integer('line_id')->unsigned()->index();
            $table->foreign('line_id')->references('id')->on('lines')->onDelete('cascade');

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
        Schema::dropIfExists('lines');
        Schema::dropIfExists('byte_line');
        if(env('DB_CONNECTION') == "mysql")
        {
            DB::statement('SET FOREIGN_KEY_CHECKS = 1');
        }
    }
}
