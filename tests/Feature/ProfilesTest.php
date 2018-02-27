<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Auth;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\User;

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

    /** @test */
    function an_unauthenticated_user_cannot_edit_a_profile()
    {
        $user = create('App\User');

        $this->withExceptionHandling()
            ->get('/{$user->username}/edit')
            ->assertRedirect('login');
    }

    /** @test */
    function an_authenticated_user_sees_an_editable_form_when_selecting_to_edit_their_profile()
    {
        $this->signIn();

        // Go the the edit page for the signed in user
        $response = $this->get('/' . Auth::user()->username . '/edit');

        // Expect to see
        $response->assertSee('Update Your Profile');
        $response->assertSee(Auth::user()->username);
        $response->assertSee('Birthdate');
    }

    /** @test */
    function an_authenticated_user_can_add_personal_data_to_their_profile()
    {
        $this->signIn();

        $this->patch(Auth::user()->username, [
            'birthdate' => '12/18/2018',
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john.doe@test.com',
            'confirm_email' => 'john.doe@test.com',
            'privacy' => '1'
        ]);

        $updatedUser = User::all()->first();

        $this->assertEquals('2018-12-18', $updatedUser->birthdate);
        $this->assertEquals('John', $updatedUser->first_name);
        $this->assertEquals('Doe', $updatedUser->last_name);
        $this->assertEquals('john.doe@test.com', $updatedUser->email);
        $this->assertEquals('1', $updatedUser->privacy);
    }

    // validation tests
    /** @test */
    function birthdate_must_be_the_right_format()
    {
        $this->signIn();

        $this->patch(Auth::user()->username, [
            'birthdate' => '18/40/2018',
            'email' => 'john.doe@test.com',
            'confirm_email' => 'john.doe@test.com',
            'privacy' => '1'
        ]);

        $updatedUser = User::all()->first();

        $this->assertEquals(NULL, $updatedUser->birthdate);
    }

    // validation tests
    /** @test */
    function privacy_must_be_a_valid_number()
    {
        $this->withExceptionHandling()->signIn();

        $this->patch(Auth::user()->username, [
            'privacy' => '3'
        ])->assertSessionHasErrors('privacy');
    }

    // validation tests
    /** @test */
    function email_and_confirmation_email_must_match()
    {
        $this->withExceptionHandling()->signIn();

        $this->patch(Auth::user()->username, [
            'email' => 'john@test.com',
            'confirm_email' => 'doe@test.com'
        ])->assertSessionHasErrors('email');
    }

// validation tests
    /** @test */
    function must_have_an_email()
    {
        $this->withExceptionHandling()->signIn();

        $this->patch(Auth::user()->username, [
            'email' => ''
        ])->assertSessionHasErrors('email');
    }}
