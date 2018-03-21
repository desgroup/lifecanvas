<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    /**
     * The registration form can be displayed.
     *
     * @return void
     */
    public function testRegisterFormDisplayed()
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    /**
     * A valid user can be registered.
     *
     * @return void
     */
    public function testRegistersAValidUser()
    {
        //$user = factory(User::class)->make();

        $response = $this->post('register', [
            'username' => 'johndoe',
            'email' => 'johndoe@test.com',
            'password' => 'secret',
            'password_confirmation' => 'secret'
        ]);

        $response->assertStatus(302);

        //$this->seeIsAuthenticated();
        $this->assertTrue(Auth::check());
    }

    /**
     * An invalid user is not registered.
     *
     * @return void
     */
    public function testDoesNotRegisterAnInvalidUser()
    {
        //$user = factory(User::class)->make();

        $response = $this->withExceptionHandling()->post('register', [
            'username' => 'johndoe',
            'email' => 'johndoe@test.com',
            'password' => 'secret',
            'password_confirmation' => 'invalid'
        ]);

        $response->assertSessionHasErrors();

        $this->dontSeeIsAuthenticated();
    }
}
