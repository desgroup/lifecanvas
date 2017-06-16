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

$factory->define(App\Byte::class, function (Faker\Generator $faker) {

    $userIds = App\User::pluck('id')->toArray();

    return [
        'title' => $faker->sentence,
        'story' => $faker->paragraph,
//        'favorite' => $faker->boolean(),
//        'rating' => $faker->numberBetween(0, 5),
//        'privacy' => $faker->numberBetween(0, 2),
//        'byte_date' => $faker->dateTimeBetween(
//            $startDate = '-30 years',
//            $endDate = 'now',
//            $timezone = 'UTC'),
//        'accuracy' => '11' . $faker->numberBetween(0, 1) . '000',
//        'timezone_id' => $faker->numberBetween(1, 200),
//        'lat' => $faker->latitude,
//        'lng' => $faker->longitude,
//        //'image_id' => $faker->numberBetween(1,200), // TODO-KGW disabled until I figure out how to choose the right one
//        'place_id' => $faker->numberBetween(1, 200),
        'user_id' => $faker->randomElement($userIds)
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
