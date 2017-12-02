<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;

class AuthenticationTest extends DuskTestCase
{
    use DatabaseMigrations;

    /** @test */
    public function registered_user_can_sign_in ()
    {
        $user = create('App\User', ['email' => 'kgwhatley@me.com']);

        $this->browse(function ($browser) use ($user) {
            $browser->visit('/login')
                ->type('email', $user->email)
                ->type('password', 'secret')
                ->press('Sign In')
                ->assertPathIs('/feed');
        });
    }

    /** @test */
    public function unregistered_user_cant_sign_in ()
    {
        $this->browse(function ($browser) {
            $browser->visit('/login')
                ->type('email', 'kgwhatley@me.com')
                ->type('password', 'secret')
                ->press('Sign In')
                ->assertPathIs('/login');
        });
    }

    /** @test */
    public function users_can_register ()
    {
        //$user = create('App\User', ['email' => 'kgwhatley@me.com']);

        $this->browse(function ($browser) {
            $browser->visit('/register')
                ->type('username', 'user')
                ->type('email', 'user@user.com')
                ->type('password', 'secret')
                ->type('password_confirmation', 'secret')
                ->press('Sign Up')
                ->assertPathIs('/feed');
        });
    }

}
