<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LifelistTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    function authenticated_users_can_add_lifelists()
    {
        // Authenticate a user
        $this->signIn();

        // Go to lines create page and see the form
        $this->get('/lists/create')
            ->assertSee('Add a Lifelist');

        // Build a line
        $list = make('App\Lifelist', ['user_id' => auth()->id(), 'name' => 'aabbccdd']);

        // Submit a line
        // See the new line in a list of lines
        $this->post('/lists', $list->toArray());

        // See the new line in a list of lines
        $this->get('/lists')
            ->assertSee($list->name);
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
        $goalToSee = create('App\Goal', ['user_id' => auth()->id(), 'name' => 'aabbccdd']);
        $goalToSee->lists()->attach($listFiltered);

        $listNotFiltered = create('App\Lifelist', ['user_id' => auth()->id()]);
        $goalToNotSee = create('App\Goal', ['user_id' => auth()->id(), 'name' => 'eeffgghh']);
        $goalToNotSee->lists()->attach($listNotFiltered);

        $this->get('/lists/' . $listFiltered->id)
            ->assertSee($goalToSee->name)
            ->assertDontSee($goalToNotSee->name);
    }

}
