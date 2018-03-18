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
    function authenticated_users_can_complete_their_goal ()
    {
        $this->signIn();

        $byte = create('App\Byte', ['user_id' => auth()->id()]);
        $goal = create('App\Goal', ['user_id' => auth()->id()]);

        $this->post('/goals/completed/' . $goal->id . '/' . $byte->id);

        //$goal->byte()->attach($byte->id);

        $this->assertCount(1, $goal->byte);
    }
}
