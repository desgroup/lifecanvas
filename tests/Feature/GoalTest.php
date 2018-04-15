<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GoalTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function authenticated_users_can_add_goals ()
    {
        $this->signIn();

        $this->get('/goals/create')
            ->assertSee('Add a Goal');

        $goal = make('App\Goal', ['user_id' => auth()->id(), 'name' => 'aabbccdd']);

        $this->post('/goals', $goal->toArray());

        $this->get('/goals')
            ->assertSee($goal->name);
    }

    /** @test */
    function unauthenticated_users_cannot_see_the_create_list_page()
    {
        $this->withExceptionHandling()
            ->get('/lists/create')
            ->assertRedirect('login');
    }

    /** @test */
    function unauthenticated_users_cannot_see_the_lifelists_list()
    {
        $this->withExceptionHandling()
            ->get('/lists')
            ->assertRedirect('login');
    }

    /** @test */
    function authenticated_users_can_view_goals_by_lifelists ()
    {
        $this->signIn();

        $listFiltered = create('App\Lifelist', ['user_id' => auth()->id()]);
        $goalToSee = create('App\Goal', ['user_id' => auth()->id(),
            'name' => 'aabbccddee']);
        $goalToSee->lists()->attach($listFiltered);

        $listNotFiltered = create('App\Lifelist', ['user_id' => auth()->id()]);
        $goalToNotSee = create('App\Goal', ['user_id' => auth()->id(),
            'name' => 'ffgghhiijj']);
        $goalToNotSee->lists()->attach($listNotFiltered);

        $this->get('/lists/' . $listFiltered->id)
            ->assertSee($goalToSee->name)
            ->assertDontSee($goalToNotSee->name);
    }

    /** @test */
    function authenticated_users_can_edit_a_goal ()
    {
        $this->signIn();

        $goal = create('App\Goal', ['user_id' => auth()->id(), 'name' => 'aabbccdd']);

        $response = $this->get('/goals/' . $goal->id . '/edit');

        $response->assertSee($goal->name);
        $response->assertSee('Update Goal');

        $goalChanged = $goal->toArray();

        $goalChanged['name'] = 'eeffgghh';

        $this->patch('/goals/' . $goal->id, $goalChanged);

        $this->get('/goals/' . $goal->id . '/edit')
            ->assertSee($goalChanged['name']);
    }

    /** @test */
    function authenticated_users_can_complete_goals_by_joining_a_byte ()
    {
        $this->signIn();

        $goal = create('App\Goal', ['user_id' => auth()->id(), 'name' => 'aabbccdd']);
        $byte = create('App\Byte', ['user_id' => auth()->id()]);

        $this->post('/goals/completed/' . $goal->id, ['byte_id' => $byte->id]);

        $this->assertEquals(1, $goal->bytes()->count());
    }

    /** @test */
    function authenticated_users_can_view_completed_goals_only ()
    {
        $this->signIn();

        $goalCompleted = create('App\Goal', ['user_id' => auth()->id(), 'name' => 'aabbccdd']);
        $byte = create('App\Byte', ['user_id' => auth()->id()]);
        $this->post('/goals/completed/' . $goalCompleted->id, ['byte_id' => $byte->id]);

        $goalUnCompleted = create('App\Goal', ['user_id' => auth()->id(), 'name' => 'eeffgghh']);

        $this->get('/goals?filter=completed')
            ->assertSee($goalCompleted->name)
            ->assertDontSee($goalUnCompleted->name);
    }

    /** @test */
    function authenticated_users_can_view_uncompleted_goals_only ()
    {
        $this->signIn();

        $goalCompleted = create('App\Goal', ['user_id' => auth()->id(), 'name' => 'aabbccdd']);
        $byte = create('App\Byte', ['user_id' => auth()->id()]);
        $this->post('/goals/completed/' . $goalCompleted->id, ['byte_id' => $byte->id]);

        $goalUnCompleted = create('App\Goal', ['user_id' => auth()->id(), 'name' => 'eeffgghh']);

        $this->get('/goals?filter=uncompleted')
            ->assertSee($goalUnCompleted->name)
            ->assertDontSee($goalCompleted->name);
    }
}
