<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GoalManagementTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function authenticated_users_can_add_goals_to_a_lifelist ()
    {
        $this->signIn();

        $list = create('App\Lifelist', ['user_id' => auth()->id()]);

        $this->get('/lists/' . $list->id)
            ->assertSee('Add a Goal');

        $goal = make('App\Goal', ['user_id' => auth()->id()]);
        $data = $goal->toArray();
        $data['lifelist_id'] = $list->id;
        //dd($data);
        $this->post('/goals', $data);

        $this->get('/lists/' . $list->id)
            ->assertSee($list->name)
            ->assertSee($goal->name);
    }

    /** @test */
    function authenticated_users_can_complete_their_goal_by_relating_it_to_an_existing_byte ()
    {
        $this->signIn();

        $byte = create('App\Byte', ['user_id' => auth()->id()]);
        $goal = create('App\Goal', ['user_id' => auth()->id()]);

        $this->post('/goals/completed/' . $goal->id, [
            'byte_id' => $byte->id
            ]);

        $this->assertCount(1, $goal->bytes);

        $response = $this->get('/goals/' . $goal->id);

        $response->assertSee($byte->title);
        $response->assertSee($goal->name);
    }

    /** @test */
    function authenticated_users_see_a_form_to_associate_a_byte_to_a_goal ()
    {
        $this->signIn();

        $goal = create('App\Goal', ['user_id' => auth()->id()]);

        $response = $this->get('/goals/complete/' . $goal->id);

        $response->assertSeeText('Select an existing Byte');
        $response->assertSeeText('Create a new Byte');
    }

    /** @test */
    function authenticated_users_can_view_a_goal_with_associated_bytes ()
    {
        $this->signIn();

        $goal = create('App\Goal', ['user_id' => auth()->id()]);
        $byte = create('App\Byte', ['user_id' => auth()->id()]);
        $byte2 = create('App\Byte', ['user_id' => auth()->id()]);

        $this->post('/goals/completed/' . $goal->id, [
            'byte_id' => $byte->id
        ]);
        $this->post('/goals/completed/' . $goal->id, [
            'byte_id' => $byte2->id
        ]);

        $response = $this->get('/goals/' . $goal->id);

        $response->assertSee($goal->name);
        $response->assertSee($byte->title);
        $response->assertSee($byte2->title);
    }

    /** @test */
    function authenticated_users_can_uncomplete_a_goal ()
    {
        $this->signIn();

        $byte = create('App\Byte', ['user_id' => auth()->id()]);
        $goal = create('App\Goal', ['user_id' => auth()->id()]);

        $this->post('/goals/completed/' . $goal->id, [
            'byte_id' => $byte->id
        ]);

        $this->assertCount(1, $goal->bytes);

        $response = $this->get('/goals/' . $goal->id);

        $response->assertSee($byte->title);
        $response->assertSee($goal->name);

        $this->post('/goals/removeByte/' . $goal->id, [
            'byte_id' => $byte->id
        ]);

        //$this->assertCount(0, $goal->bytes);

        $response = $this->get('/goals/' . $goal->id);

        $response->assertDontSee($byte->title);
        $response->assertSee($goal->name);
    }

}
