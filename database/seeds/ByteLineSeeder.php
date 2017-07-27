<?php

use App\Byte;
use App\Line;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ByteLineSeeder extends Seeder
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
        $lineId = Line::pluck('id')->toArray();

        foreach (range(1, 500) as $index) {
            DB::table('byte_line')->insert([
                'byte_id' => $faker->randomElement($byteId),
                'line_id' => $faker->randomElement($lineId)
            ]);
        }
    }
}
