<?php

namespace Tests\Feature;

use PlacesTableSeeder;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use TimezonesTableSeeder;

class GrabTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function authorized_users_can_grab_another_users_byte ()
    {
        $this->signIn();

        $seeder = new TimezonesTableSeeder();
        $seeder->run();

        $seeder = new PlacesTableSeeder();
        $seeder->run();

        $orginalByte = create('App\Byte', ['user_id' => auth()->id()]);

        //dd('/bytes/grab/' . $orginalByte->id);

        $this->post('/bytes/grab/' . $orginalByte->id);

        $this->get('/bytes/2')
            ->assertSee($orginalByte->title);
    }
}
