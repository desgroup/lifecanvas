<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBytesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bytes', function (Blueprint $table) {
            $table->increments('id');
            // Mandatory title for the byte
            $table->string('title');
            // Optional free text to elaborate on the byte
            $table->text('story')->nullable();
            // 5 star rating
            $table->tinyInteger('rating')->nullable();
            // privacy setting for the byte: 0 is private, 1 is friends, 2 is world
            $table->tinyInteger('privacy')->default('0');
            // The timezone id for the byte_date that provides the UTC offset
            $table->integer('timezone_id')->nullable()->unsigned();
            // The date the byte happened in UTC, can be empty
            $table->dateTime('byte_date')->nullable();
            // A code that indicates what part of the date you are sure of
            $table->string('accuracy')->nullable();
            // The latitude where the byte was captured from the device, can be Null
            $table->double('lat')->nullable();
            // The longitude where the byte was captured from the device, can be Null
            $table->double('lng')->nullable();
            // The id for the record in the image table
            $table->integer('asset_id')->nullable()->unsigned();
            // The id for the record for the place associated with the byte
            $table->integer('place_id')->nullable()->unsigned();
            // The user id for the user that created the byte
            $table->integer('user_id')->unsigned();
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
        Schema::dropIfExists('bytes');
    }
}
