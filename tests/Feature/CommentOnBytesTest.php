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

    /** @test */
    function unauthorized_users_cannot_delete_comments()
    {
        $this->withExceptionHandling();

        $comment = create('App\Comment', ['user_id' => 1, 'byte_id' => 1]);

        $this->delete("/comments/{$comment->id}")
            ->assertRedirect('signin');

        $this->signIn()
            ->delete("/comments/{$comment->id}")
            ->assertStatus(403);
    }

    /** @test */
    function authorized_users_can_delete_their_comments()
    {
        $this->signIn();

        $comment = create('App\Comment', ['user_id' => auth()->id(), 'byte_id' => 1]);

        $this->delete("/comments/{$comment->id}")
            ->assertStatus(302);

        $this->assertDatabaseMissing('comments', ['id' => $comment->id]);
    }

    // validation tests
    /** @test */
    function a_comment_requires_a_body()
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
