<?php

use Illuminate\Database\Seeder;

class ActivityTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $bytes = App\Byte::all();

        foreach ($bytes as $byte) {
            factory(App\Activity::class, rand(0,10))->create(['byte_id' => $byteId]);
        }
    }
}
