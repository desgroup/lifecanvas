<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class LinesTagBytesTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    function authenticated_users_can_view_bytes_by_lifelines()
    {
        // Authenticate a user
        $this->signIn();

        // With bytes with lifelines
        $lineFiltered = create('App\Line', ['name' => 'Test1', 'user_id' => auth()->id()]);
        $lineNotFiltered = create('App\Line', ['name' => 'Test2', 'user_id' => auth()->id()]);

        $byteToSee = factory('App\Byte')->create(['user_id' => auth()->id()]);
        $byteToSee->lines()->attach($lineFiltered);
        $byteToNotSee = factory('App\Byte')->create(['user_id' => auth()->id()]);
        $byteToNotSee->lines()->attach($lineNotFiltered);

        // Go to a page filtered by one of the lifelines
        // The users sees a byte associated with that line
        // And doesn't see a byte not associated with that line
        $this->get('/lines/' . $lineFiltered->id)
            ->assertSee($byteToSee->title)
            ->assertDontSee($byteToNotSee->title);
    }

    /** @test */
    function authenticated_users_can_see_a_list_of_lifelines()
    {
        $this->signIn();

        $line = create('App\Line', ['user_id' => auth()->id()]);
        //dd($line);

        $this->get('/lines')
            ->assertSee($line->name);
    }

    /** @test */
    function authenticated_users_can_add_lifelines()
    {
        // Authenticate a user
        $this->signIn();

        // Go to lines create page and see the form
        $this->get('/lines/create')
            ->assertSee('Add a Lifeline');

        // Build a line
        $line = make('App\Line');

        // Submit a line
        // See the new line in a list of lines
        $this->post('/lines', $line->toArray());

        // See the new line in a list of lines
        $this->get('/lines')
            ->assertSee($line->name);
    }

    /** @test */
    function a_user_can_tag_their_bytes_with_lifelines() // Maybe do one for on creation, and one for adding later?
    { // TODO-KGW not finished test. Remove of finish when you add a asynchronous tagging mechanism.
//        // A signed in user
//        $this->signIn();
//
//        // with a byte
//        $byte = create('App\Byte', ['user_id' => auth()->id()]);
//        $line1 = create('App\Line', ['name' => 'Test1', 'user_id' => auth()->id()]);
//        $line2 = create('App\Line', ['name' => 'Test2', 'user_id' => auth()->id()]);
//
//        $this->put('/bytes/' . $byte->id, ['name' => [1,2]]);
//
//        $this->get('/bytes/' . $byte->id)
//            ->assertSee($line1->name)
//            ->assertSee($line2->name);
    }

    // validation tests
    /** @test */
    function a_line_requires_a_name()
    {
        $this->addLine(['name' => null])
            ->assertSessionHasErrors('name');
    }

    /** @test */
    function a_line_requires_a_unique_name()
    {
        $this->addLine(['name' => 'Test']);

        $this->addLine(['name' => 'Test'])
            ->assertSessionHasErrors('name');
    }

    public function addLine($overrides = [])
    {
        $this->withExceptionHandling()->signIn();

        $byte = make('App\Line', $overrides);

        return $this->post('/lines', $byte->toArray());
    }
}
