<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlacesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('places', function (Blueprint $table) {
            $table->increments('id');
            // Name of the place to the user
            $table->string('name');
            // Street address for the place, can be Null
            $table->string('address')->nullable();
            // City name for the place, can be Null
            $table->string('city')->nullable();
            // Province or state for the place, can be Null - TODO-KGW need to decide if this is a code or written out
            $table->string('province')->nullable();
            // The ISO country code for the place's country, can be Null
            $table->string('country_code')->nullable();
            // The ISO country code for the place's country, can be Null
            $table->boolean('extant')->default(true);
            // The official web site URL for the place, can be Null - TODO-KGW should we keep this?
            $table->string('url_place')->nullable();
            // The URL for the place's associated wikipedia page, can be Null
            $table->string('url_wikipedia')->nullable();
            // The latitude of the place, can be Null
            $table->double('lat')->nullable();
            // The longitude of the place, can be Null
            $table->double('lng')->nullable();
            // The chosen zoom level for the map, can be Null
            $table->tinyInteger('map_zoom')->nullable();
            // The id for the image record associated with this place, can be Null
            $table->integer('image_id')->nullable()->unsigned();
            // Timezone for the place, can be Null
            $table->integer('timezone_id')->nullable()->unsigned();
            // The user id that owns / created this place
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
        Schema::dropIfExists('places');
    }
}
