<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ProfilesTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    function unauthenticated_users_cannot_see_profiles_pages()
    {
        $user = create('App\User');

        $this->withExceptionHandling()
            ->get("/{$user->username}")
            ->assertRedirect('/login');
    }

    /** @test */
    function a_user_has_a_profile_accessible_by_authenticated_users()
    {
        $this->signIn();

        $user = create('App\User');

        $this->get("/{$user->username}")
            ->assertSee( $user->username );
    }

    /** @test */
    function profile_displays_latest_user_activity()
    {
        $this->signIn();

        $byte = create('App\Byte', ['user_id' =>auth()->id()]);
        $this->post('/bytes/' . $byte->id . '/favorites');
        $line = create('App\Line', ['user_id' =>auth()->id()]);
        $place = create('App\Place', ['user_id' =>auth()->id()]);
        $person = create('App\Person', ['user_id' =>auth()->id()]);

        $this->get("/" . auth()->user()->username)
            ->assertSee($byte->title)
            ->assertSee('favorited:')
            ->assertSee($byte->story)
            ->assertSee($line->name)
            ->assertSee($place->name)
            ->assertSee($person->name);
    }
}
