<?php

use Illuminate\Database\Seeder;

class BytesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Byte::class, 100)->create();
    }
}
