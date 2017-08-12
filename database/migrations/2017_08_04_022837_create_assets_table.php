<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAssetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assets', function (Blueprint $table) {
            $table->increments('id');
            // The modified filename of the file stored in the system
            $table->string('file_name');
            // The extension of the file. This will drive how the file will be presented.
            $table->string('extension')->nullable();
            // The file size in kilobytes
            $table->integer('size_kb')->nullable();
            // The height of the original file in pixels for image type files.
            $table->integer('height_px')->nullable();
            // The width of the original file in pixels for image type files.
            $table->integer('width_px')->nullable();
            // The date the asset was created in local time. This is typically pulled from the file.
            $table->dateTime('asset_date_local')->nullable();
            // The timezone id for the asset_date that provides the UTC offset, can be Null
            $table->integer('timezone_id')->nullable()->unsigned();
            // The latitude where the asset was captured taken from the file where available, can be Null
            $table->double('lat')->nullable();
            // The longitude where the asset was captured taken from the file where available, can be Null
            $table->double('lng')->nullable();
            // The user id for the user that attached the asset.
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
        Schema::dropIfExists('assets');
    }
}
