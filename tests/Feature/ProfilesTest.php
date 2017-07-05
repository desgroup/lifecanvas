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
            ->assertRedirect('/signin');
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
    function profiles_display_all_public_bytes_created_by_user()
    {
        $this->signIn();

        $user = create('App\User');

        $byte = create('App\Byte', ['user_id' => $user->id]);

        $this->get("/{$user->username}")
            ->assertSee($byte->title)
            ->assertSee($byte->story);
    }
}
