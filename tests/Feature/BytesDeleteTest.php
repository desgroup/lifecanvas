<?php

namespace Tests\Feature;

use App\Activity;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class BytesDeleteTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    function unauthorized_users_cannot_delete_bytes ()
    {
        $this->withExceptionHandling();

        $byte = create('App\Byte', ['user_id' => 2]);

        $this->delete($byte->path())
            ->assertRedirect('/login');

        $this->signIn();
        $this->json('DELETE', $byte->path())
            ->assertStatus(403);
    }

    /** @test */
    function authorized_users_can_delete_bytes ()
    {
        $this->signIn();

        $byte = create('App\Byte', ['user_id' => auth()->id()]);
        $comment = create('App\Comment', ['byte_id' => $byte->id]);

        $response = $this->json('DELETE', $byte->path());

        $response->assertStatus(204);

        $this->assertDatabaseMissing('bytes', ['id' => $byte->id]);
        $this->assertDatabaseMissing('comments', ['id' => $comment->id]);

        $this->assertEquals(0, Activity::count());
    }
}
