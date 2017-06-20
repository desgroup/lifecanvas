<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class LandingPageTest extends TestCase
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

    /** @test */ // TODO-KGW This test needs to be completed, redirect is not working.
//    public function a_signed_in_user_sees_their_feed_page_when_hitting_root_page()
//    {
//        // Sign-in as first user
//        $this->be($this->user);
//
//        //$this->followRedirects();
//
//        // Go to lifecanvas.io root
//        $response = $this->get('/');
//
//        //$this->assertRedirectedToRoute('feed');
//
//        // See the feed page
//        //$response->assert('/feed'); // is the right URL
//        $response->assertSee('Feed');
//    }
}
