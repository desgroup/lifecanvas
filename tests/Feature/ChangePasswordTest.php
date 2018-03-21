<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Auth;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ChangePasswordTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function authenticated_users_can_see_a_password_change_form ()
    {
        $this->signIn();

        $response = $this->get('/changePassword');

        $response->assertSee('Change Password');
    }

    /** @test */
    function unauthenticated_users_cannot_see_a_password_change_form ()
    {
        $this->withExceptionHandling()
            ->get('/changePassword')
            ->assertRedirect('login');
    }

    /** @test */
    function authenticated_users_can_change_their_password ()
    {
        //$this->expectException('Illuminate\Auth\AuthenticationException');

        $this->registerAndSignIn();

        $this->post('/changePassword', [
            'current-password' => 'secret',
            'new-password' => 'secret2',
            'new-password_confirmation' => 'secret2'
        ]);

        Auth::logout();

        $response = $this->post('/login', [
            'email' => 'johndoe@test.com',
            'password' => 'secret2'
        ]);

        $response->assertStatus(302);

        $this->assertTrue(Auth::check());
    }

    /** @test */
    function existing_password_must_match ()
    {
        //$this->expectException('Illuminate\Auth\AuthenticationException');

        $this->registerAndSignIn();

        $response = $this->post('/changePassword', [
            'current-password' => 'secret3',
            'new-password' => 'secret2',
            'new-password_confirmation' => 'secret2'
        ]);

        $response->assertSessionHasErrors();
    }

    /** @test */
    function new_password_must_match_confirmation_password ()
    {
        $this->expectException('Illuminate\Validation\ValidationException');

        $this->registerAndSignIn();

        $this->post('/changePassword', [
            'current-password' => 'secret',
            'new-password' => 'secret2',
            'new-password_confirmation' => 'secret3'
        ]);
    }

    /** @test */
    function user_must_provide_a_confirmation_password ()
    {
        $this->expectException('Illuminate\Validation\ValidationException');

        $this->registerAndSignIn();

        $this->post('/changePassword', [
            'current-password' => 'secret',
            'new-password' => 'secret2',
            'new-password_confirmation' => ''
        ]);
    }

    /** @test */
    function new_password_must_be_different_than_existing_password ()
    {
        //$this->expectException('Illuminate\Validation\ValidationException');

        $this->registerAndSignIn();

        $response = $this->post('/changePassword', [
            'current-password' => 'secret',
            'new-password' => 'secret',
            'new-password_confirmation' => 'secret'
        ]);

        $response->assertSessionHasErrors();
    }

    function registerAndSignIn ()
    {
        $this->post('register', [
            'username' => 'johndoe',
            'email' => 'johndoe@test.com',
            'password' => 'secret',
            'password_confirmation' => 'secret'
        ]);

        $this->post('/login', [
            'email' => 'johndoe@test.com',
            'password' => 'secret'
        ]);
    }

}
