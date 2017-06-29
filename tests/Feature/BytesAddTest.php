<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AddBytesTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    function unauthenticated_users_cannot_see_the_create_byte_page()
    {
        $this->withExceptionHandling()
            ->get('/bytes/create')
            ->assertRedirect('signin');
    }

    /** @test */
    function unauthenticated_users_cannnot_add_bytes()
    {
        $this->expectException('Illuminate\Auth\AuthenticationException');

        $byte = factory('App\Byte')->make();

        $this->post('/bytes', $byte->toArray());
    }

    /** @test */
    function authenticated_user_can_add_a_byte()
    {
        $this->signIn(); // TODO-KGW Using the Laracast helper method. Should standardize if going to use.

        $byte = factory('App\Byte')->make();

        $this->post('/bytes', $byte->toArray());

        $this->get('/bytes')
            ->assertSee($byte->title)
            ->assertSee($byte->story);
    }

    // validation tests
    /** @test */
    function a_thread_requires_a_title()
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
