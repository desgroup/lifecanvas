<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCountriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('countries', function (Blueprint $table) {
            // Data is from: https://github.com/lukes/ISO-3166-Countries-with-Regional-Codes/blob/master/all/all.csv
            // The ISO 3166 2 letter code for the country
            $table->string('id')->unique();
            // The ISO 3 letter code for the country
            $table->string('code_3')->unique();
            // The ISO 3 number code for the country
            $table->string('code_num')->unique();
            // The country name in English
            $table->string('country_name_en');
            // The made up code for the continent for when I normalize things
            $table->string('continent_id');
            // The continent name in English for the 7 continent model
            $table->string('continent_name_en');
            // A code for the region; I think this is ISO
            $table->string('region_id');
            // The region name in English
            $table->string('region_name_en');
            // A code for the sub region; I think this is ISO
            $table->string('subregion_id');
            // The sub region name in English
            $table->string('subregion_name_en');
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
        Schema::dropIfExists('countries');
    }
}
