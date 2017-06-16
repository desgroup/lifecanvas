<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class LoginTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp()
    {
        parent::setUp();

        $this->user = factory(\App\User::class)->create();

    }

    /** @test */
    public function a_signed_out_user_sees_the_welcome_page_when_hitting_lifecanvas()
    {
        // Don't be logged in
        // Go to lifecanvas.io root
        $response = $this->get('/');

        // Go to lifecanvas.io
        $response->assertSee('Sign Up');
    }

    /** @test */
    public function a_signed_in_user_sees_their_feed_page_when_hitting_lifecanvas()
    {
        // Sign-in as first user
        $this->be($this->user);

        // Go to lifecanvas.io root
        $response = $this->get('/');

        // See the feed page
        //$response->assert('/feed'); // is the right URL
        $response->assertSee('Byte Feed');
    }
}
