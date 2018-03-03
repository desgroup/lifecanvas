<?php

namespace Tests\Feature;

use PlacesTableSeeder;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use TimezonesTableSeeder;

class BytesViewTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp()
    {
        parent::setUp();

        $this->user = factory(\App\User::class)->create();
        $this->be($this->user);
        create('App\Place', ['user_id' => auth()->id()]);
        $this->byte1 = factory(\App\Byte::class)->create([
            'user_id' => $this->user->id,
            'title' => 'This is my first byte'
        ]);
        $this->byte2 = factory(\App\Byte::class)->create([
            'user_id' => $this->user->id,
            'title' => 'This is my second byte'
        ]);
        $this->userComment = factory(\App\Comment::class)->create([
            'user_id' => $this->user->id,
            'byte_id' => $this->byte1->id,
            'body' => 'Byte comment'
        ]);

        $this->otherUser = factory(\App\User::class)->create();
        $this->otherUserByte = factory(\App\Byte::class)->create([
            'user_id' => $this->otherUser->id,
            'title' => 'Other users byte'
        ]);
        $this->otherUserComment = factory(\App\Comment::class)->create([
            'user_id' => $this->otherUser->id,
            'byte_id' => $this->otherUserByte->id,
            'body' => 'Byte comment'
        ]);
    }

    /** @test */
    public function a_user_can_browse_their_bytes_when_signed_in()
    {
        // Create two bytes from the signed-in user
        // Create a byte from another user
        // Sign-in as first user
        $this->be($this->user);

        // Go the the byte list page
        $response = $this->get('/bytes');

        // Expect to see the two bytes
        $response->assertSee($this->byte1->title);
        $response->assertSee($this->byte2->title);

        // Expect to not see other user's byte
        $response->assertDontSee($this->otherUserByte->title);
    }

    /** @test */
    public function a_user_can_view_a_specific_byte_they_created()
    {
        $seeder = new TimezonesTableSeeder();
        $seeder->run();

        $seeder = new PlacesTableSeeder();
        $seeder->run();

        //dd($this->byte1);
        $response = $this->get('/bytes/' . $this->byte1->id);

        $response->assertSee($this->byte1->title);

        // Should see the associated comment
        $response->assertSee($this->userComment->body);
    }

    /** @test  */
    public function a_user_can_read_comments_that_are_associated_with_a_byte_they_created()
    {
        $seeder = new TimezonesTableSeeder();
        $seeder->run();

        $seeder = new PlacesTableSeeder();
        $seeder->run();

        $comment = factory('App\Comment')->create(['byte_id' => $this->byte1->id]);

        $response = $this->get('/bytes/' . $this->byte1->id);
        $response->assertSee($comment->body);
    }


}
