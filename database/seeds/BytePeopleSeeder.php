<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use App\Byte;
use App\Person;

class BytePeopleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        $byteId = Byte::pluck('id')->toArray();
        $personId = Person::pluck('id')->toArray();

        foreach (range(1, 100) as $index) {
            DB::table('byte_person')->insert([
                'byte_id' => $faker->randomElement($byteId),
                'person_id' => $faker->randomElement($personId)
            ]);
        }
    }
}
