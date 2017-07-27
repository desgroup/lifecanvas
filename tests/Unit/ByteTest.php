<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ByteTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp()
    {
        parent::setUp();

        $user = factory('App\User')->create();
        $this->byte = factory('App\Byte')->create(['user_id' => $user->id]);
    }

    /** @test */
    function a_byte_has_comments()
    {
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $this->byte->comments);
    }

    /** @test */
    function a_thread_has_a_creator()
    {
        $this->assertInstanceOf('App\User', $this->byte->creator);
    }

    /** @test */
    function a_byte_can_add_a_comment()
    {
        $this->byte->addComment([
            'body' => 'Foobar',
            'user_id' => 1
        ]);

        $this->assertCount(1, $this->byte->comments);
    }

    /** @test */
    function a_byte_can_be_tagged_with_lifelines()
    {
        create('App\Line');

        $this->byte->lines()->attach([
            1
        ]);
    }
}
