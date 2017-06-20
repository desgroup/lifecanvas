<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CommentOnBytesTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    // TODO-KGW I don't know if this is needed. You must be authenticated to do anything in the app.
    function unauthenticated_users_cannot_add_comments_to_bytes()
    {
        $this->expectException('Illuminate\Auth\AuthenticationException');

        $this->post('/bytes/1/comment', []);
    }

    /** @test */
    function authenticated_users_can_add_comments_to_bytes()
    {
        $this->be($user = factory('App\User')->create());

        $byte = factory('App\Byte')->create();

        $comment = factory('App\Comment')->make();
        $this->post($byte->path() . '/comment', $comment->toArray());

        $this->get($byte->path())
            ->assertSee($comment->body);
    }

    // validation tests
    /** @test */
    function a_thread_requires_a_comment()
    {
        $this->addComment(['body' => null])
            ->assertSessionHasErrors('body');
    }

    public function addComment($overrides = [])
    {
        $this->withExceptionHandling()->signIn();
        $byte = create('App\Byte');

        $comment = make('App\Comment', $overrides);

        return $this->post("/bytes/$byte->id/comment", $comment->toArray());
    }
}
