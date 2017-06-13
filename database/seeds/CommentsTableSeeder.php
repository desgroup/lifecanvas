<?php

use Illuminate\Database\Seeder;

class CommentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $byteIds = App\Byte::pluck('id')->toArray();

        foreach ($byteIds as $byteId) {
            factory(App\Comment::class, rand(0,10))->create(['byte_id' => $byteId]);
        }
    }
}
