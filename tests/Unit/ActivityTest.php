<?php

namespace Tests\Unit;

use App\Activity;
use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ActivityTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    function it_records_activity_when_a_byte_is_created()
    {
        $this->signIn();

        $byte = create('App\Byte', ['user_id' => auth()->id()]);

        $this->assertDatabaseHas('activities', [
            'type' => 'created_byte',
            'user_id' => auth()->id(),
            'subject_id' => $byte->id,
            'subject_type' => 'App\Byte'
        ]);

        $activity = Activity::first();

        $this->assertEquals($activity->subject_id, $byte->id);
    }

    /** @test */
    function it_records_activity_when_a_comment_is_created()
    {
        $this->signIn();

        $byte = create('App\Byte');
        create('App\Comment', ['byte_id' => $byte->id]);

        $this->assertEquals(2, Activity::count());
    }

    /** @test */
    function it_records_activity_when_a_user_favorites_something()
    {
        $this->signIn();

        $byte = create('App\Byte');
        $this->post('/bytes/' . $byte->id . '/favorites');

        $this->assertEquals(2, Activity::count());
    }

    /** @test */
    function it_records_activity_when_a_user_adds_a_lifeline()
    {
        $this->signIn();

        create('App\Line');

        $this->assertEquals(1, Activity::count());
    }

    /** @test */
    function it_fetches_an_activity_feed_for_a_given_user()
    {
        $this->signIn();

        create('App\Byte', ['user_id' => auth()->id(), 'created_at' => Carbon::now()->subWeek()]);
        create('App\Byte', ['user_id' => auth()->id()]);

        // Adjust the time of the activity for the first thread to being out a week
        auth()->user()->activity()->first()->update(['created_at' => Carbon::now()->subWeek()]);

        $feed = Activity::feed(auth()->user(), 50);

        $this->assertTrue($feed->keys()->contains(
            Carbon::now()->format('Y-m-d')
        ));

        $this->assertTrue($feed->keys()->contains(
            Carbon::now()->subWeek()->format('Y-m-d')
        ));
    }
}
