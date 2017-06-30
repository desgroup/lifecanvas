<?php

use Illuminate\Database\Seeder;

class LinesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $userIds = App\User::pluck('id')->toArray();

        foreach ($userIds as $userId) {
            factory(App\Line::class, rand(2,8))->create(['user_id' => $userId]);
        }

        $bytes = App\Byte::all();

        foreach ($bytes as $byte) {
            $lines = App\Line::where('user_id', $byte->user_id)->get();
            //dd($lines);
            foreach ($lines as $line) {
                if((bool)random_int(0, 1)) {
                    $byte->lines()->attach($line);
                }
            }
        }
    }
}
