<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon as Carbon;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert(
            [
                'name' => 'Kyle Whatley',
                'email' => 'kgwhatley@me.com',
                'password' => bcrypt('password'),
                'remember_token' => str_random(10),
                'created_at' => Carbon::Now(),
                'updated_at' => Carbon::Now()
            ]
        );

        DB::table('users')->insert(
            [
                'name' => 'Taylor Whatley',
                'email' => 'sumofless@gmail.com',
                'password' => bcrypt('password'),
                'remember_token' => str_random(10),
                'created_at' => Carbon::Now(),
                'updated_at' => Carbon::Now()
            ]
        );

        factory(App\User::class, 5)->create();
    }
}
