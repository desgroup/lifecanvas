<?php

namespace Tests\Feature;

use App\Timezone;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PlacesTableSeeder;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use TimezonesTableSeeder;

class BytesAddTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function unauthenticated_users_cannot_see_the_create_byte_page()
    {
        $this->withExceptionHandling()
            ->get('/bytes/create')
            ->assertRedirect('login');
    }

    /** @test */
    function unauthenticated_users_cannot_add_bytes()
    {
        $this->expectException('Illuminate\Auth\AuthenticationException');

        $byte = factory('App\Byte')->make();

        $this->post('/bytes', $byte->toArray());
    }

    /** @test */
    function authenticated_user_can_add_a_byte()
    {
        $this->signIn(); // TODO-KGW Using the Laracast helper method. Should standardize if going to use.

        $seeder = new TimezonesTableSeeder();
        $seeder->run();

        $seeder = new PlacesTableSeeder();
        $seeder->run();

        $byte = make('App\Byte', ['user_id' => auth()->id()]);
        $byteArray = $byte->toArray();

        $line1 = create('App\Line', ['name' => 'Test1', 'user_id' => auth()->id()]);
        $line2 = create('App\Line', ['name' => 'Test2', 'user_id' => auth()->id()]);
        $lines = ['lines' => [$line1->id, $line2->id]];
        $byteArray = array_merge($byteArray, $lines);

        $this->post('/bytes', $byteArray);

        $this->get('/bytes/1')
            ->assertSee($byte->title)
            ->assertSee($byte->story)
            ->assertSee($line1->name)
            ->assertSee($line2->name);
    }

    // validation tests
    /** @test */
    function a_byte_requires_a_title()
    {
        $this->addByte(['title' => null])
            ->assertSessionHasErrors('title');
    }

    public function addByte($overrides = [])
    {
        $this->withExceptionHandling()->signIn();

        $byte = make('App\Byte', $overrides);

        return $this->post('/bytes', $byte->toArray());
    }
}
