<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CommentTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    function a_comment_has_an_owner()
    {
        $user = factory ('App\User')->create();
        $byte = factory ('App\Byte')->create(['user_id' => $user->id]);
        $comment = factory ('App\Comment')->create(['user_id' => $user->id, 'byte_id' => $byte->id]);

        $this->assertInstanceOf('App\User', $comment->owner);
    }
}
