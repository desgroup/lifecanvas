<?php

namespace Tests\Feature;

use App\Byte;
use PlacesTableSeeder;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use TimezonesTableSeeder;

class GrabTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function authenticated_users_can_grab_another_users_public_bytes ()
    {
        $this->signIn();

        $otherUser = create('App\User');

        $seeder = new TimezonesTableSeeder();
        $seeder->run();

        $seeder = new PlacesTableSeeder();
        $seeder->run();

        $otherUserByte = create('App\Byte', ['user_id' => $otherUser->id, 'privacy' => 2]);

        $this->post('/bytes/grab/' . $otherUserByte->id)
            ->assertSee($otherUserByte->title);
    }

    /** @test */
    function authenticated_nonfriended_users_cannot_grab_another_users_friend_bytes ()
    {
        $this->signIn();

        $otherUser = create('App\User');

        $seeder = new TimezonesTableSeeder();
        $seeder->run();

        $seeder = new PlacesTableSeeder();
        $seeder->run();

        $otherUserByte = create('App\Byte', ['user_id' => $otherUser->id, 'privacy' => 1]);

        $this->post('/bytes/grab/' . $otherUserByte->id)
            ->assertSee('Access Warning')
            ->assertDontSee($otherUserByte->title);
    }

    /** @test */
    function authenticated_friended_users_can_grab_another_users_friend_bytes ()
    {
        $this->signIn();

        $friend = createUser();

        $this->post('/friend/' . $friend->username);

        $seeder = new TimezonesTableSeeder();
        $seeder->run();

        $seeder = new PlacesTableSeeder();
        $seeder->run();

        $otherUserByte = create('App\Byte', ['user_id' => $friend->id, 'privacy' => 1]);

        $this->post('/bytes/grab/' . $otherUserByte->id)
            ->assertSee($otherUserByte->title);
    }

    /** @test */
    function authenticated_users_cannot_grab_another_users_private_bytes ()
    {
        $this->signIn();

        $otherUser = create('App\User');

        $seeder = new TimezonesTableSeeder();
        $seeder->run();

        $seeder = new PlacesTableSeeder();
        $seeder->run();

        $otherUserByte = create('App\Byte', ['user_id' => $otherUser->id, 'privacy' => 0]);

        $this->post('/bytes/grab/' . $otherUserByte->id)
            ->assertSee('Access Warning')
            ->assertDontSee($otherUserByte->title);
    }

    /** @test */
    function unauthenticated_users_cannot_grab_bytes ()
    {
        $this->withExceptionHandling()
            ->post('/bytes/grab/1')
            ->assertRedirect('login');
    }
}
