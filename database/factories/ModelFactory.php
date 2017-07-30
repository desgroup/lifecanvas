<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'username' => $faker->userName,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Line::class, function (Faker\Generator $faker) {

    $userIds = App\User::pluck('id')->toArray();

    return [
        'name' => $faker->word,
        'user_id' => $faker->randomElement($userIds)
    ];
});

$factory->define(App\Place::class, function (Faker\Generator $faker) {

    $timezones = [];
    $userIds = App\User::pluck('id')->toArray();
    $countryCodes = DB::table('countries')->select('id')->get()->toArray();
    $countryCode = $faker->randomElement($countryCodes);
    if(! is_null ($countryCode)) {
        $timezones = DB::table('timezones')->where('country_code', '=', $countryCode->id)->get()->toArray();
        $cc = $countryCode->id;
    } else {
        $cc = 1;
    }
    if($timezones == []) {
        $tz = 1;
    } else {
        $tz = $faker->randomElement($timezones)->id;
    }

    return [
        'name' => $faker->city,
        'address' => $faker->streetAddress,
        'city' => $faker->city,
        'province' => $faker->stateAbbr,
        'country_code' => $cc,
        'extant' => 1,
        'url_place' => $faker->url,
        'url_wikipedia' => $faker->url,
        'lat' => $faker->latitude,
        'lng' => $faker->longitude,
        'map_zoom' => $faker->numberBetween(10, 19),
        'image_id' => $faker->numberBetween(1, 50),
        'timezone_id' => $tz,
        'user_id' => $faker->randomElement($userIds)
    ];
});

$factory->define(App\Person::class, function (Faker\Generator $faker) {
    $relationships = [
        null,
        'Father',
        'Mother',
        'Friend',
        'Son',
        'Daughter',
        'Sibling'
    ]; // TODO-KGW Need to add a relationships lookup table for Person

    return [
        'name' => $faker->name,
        'relationship' => $faker->numberBetween(0, 6),
        'account_id' => null,
        'user_id' => $faker->numberBetween(0, 12)
    ];
});

$factory->define(App\Byte::class, function (Faker\Generator $faker) {

    $userIds = App\User::pluck('id')->toArray();
    $userId = $faker->randomElement($userIds);
    $places = DB::table('places')->where('user_id', '=', $userId)->get()->toArray();
    if($places == []) {
        $place_id = 1;
        $place_tz = 1;
    } else {
        $place = $faker->randomElement($places);
        $place_id = $place->id;
        $place_tz = $place->timezone_id;
    }

    return [
        'title' => $faker->sentence,
        'story' => $faker->paragraph,
        'rating' => $faker->numberBetween(0, 5),
        'privacy' => $faker->numberBetween(0, 2),
        'byte_date' => $faker->dateTimeBetween(
            $startDate = '-30 years',
            $endDate = 'now',
            $timezone = 'UTC'),
        'accuracy' => '11' . $faker->numberBetween(0, 1) . '000',
        'timezone_id' => $place_tz,
        'lat' => $faker->latitude,
        'lng' => $faker->longitude,
//        //'image_id' => $faker->numberBetween(1,200), // TODO-KGW disabled until I figure out how to choose the right one
        'place_id' => $place_id,
        'user_id' => $userId
    ];
});

$factory->define(App\Comment::class, function (Faker\Generator $faker) {

    $userIds = App\User::pluck('id')->toArray();
    $byteIds = App\Byte::pluck('id')->toArray();

    return [
        'body' => $faker->paragraph,
        'byte_id' => $faker->randomElement($byteIds),
        'user_id' => $faker->randomElement($userIds)
    ];
});

