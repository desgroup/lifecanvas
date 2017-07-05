<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class FavoritesTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    function unauthenticated_users_cannot_favorite_bytes()
    {
        $this->withExceptionHandling()
            ->post('/bytes/1/favorites')
            ->assertRedirect('/signin');
    }

    /** @test  */
    public function an_authenticated_user_can_favorite_bytes()
    {
        $this->signIn();

        $byte = create('App\Byte');

        $this->post('/bytes/' . $byte->id . '/favorites');

        $this->assertCount(1, $byte->favorites);
    }

    /** @test  */
    public function an_authenticated_user_can_favorite_a_byte_only_once()
    {
        $this->signIn();

        $byte = create('App\Byte');

        try {
            $this->post('bytes/' . $byte->id . '/favorites');
            $this->post('bytes/' . $byte->id . '/favorites');
        } catch (\Exception $e) {
            $this->fail('Tried to favorite same byte twice');
        }

        $this->assertCount(1, $byte->favorites);
    }
}
