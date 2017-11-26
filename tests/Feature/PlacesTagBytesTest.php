<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class PlacesTagBytesTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    function unauthenticated_users_cannot_see_the_a_place_list()
    {
        $this->withExceptionHandling()
            ->get('/places')
            ->assertRedirect('login');
    }

    /** @test */
    function authenticated_users_can_see_a_list_of_their_places()
    {
        $this->signIn();

        $place = create('App\Place', ['user_id' => auth()->id()]);
        $place_otherUser = create('App\Place', ['user_id' => 2]);

        $this->get('/places')
            ->assertSee($place->name)
            ->assertDontSee($place_otherUser->name);
    }

    /** @test */
    function authenticated_users_can_view_bytes_by_place()
    {
        // Authenticate a user
        $this->signIn();

        // With bytes with places
        $placeFiltered = create('App\Place', ['name' => 'Test1', 'user_id' => auth()->id()]);
        $placeNotFiltered = create('App\Place', ['name' => 'Test2', 'user_id' => auth()->id()]);

        $byteToSee = factory('App\Byte')->create(['user_id' => auth()->id(), 'place_id' => $placeFiltered->id]);
        $byteToNotSee = factory('App\Byte')->create(['user_id' => auth()->id(), 'place_id' => $placeNotFiltered->id]);

        // Go to a page filtered by one of the places
        // The users sees a byte associated with that place
        // And doesn't see a byte not associated with that place
        $this->get('/places/' . $placeFiltered->id)
            ->assertSee($byteToSee->title)
            ->assertDontSee($byteToNotSee->title);
    }

    /** @test */
    function unauthenticated_users_cannot_see_the_create_place_page()
    {
        $this->withExceptionHandling()
            ->get('/places/create')
            ->assertRedirect('login');
    }

    /** @test */
    function authenticated_users_can_add_places()
    {
        // Authenticate a user
        $this->signIn();

        // Go to lines create page and see the form
        $this->get('/places/create')
            ->assertSee('Add a Place');

        // Build a line
        $place = make('App\Place', ['name' => "O'Conner"]);

        // Submit a line
        // See the new line in a list of lines
        $this->post('/places', $place->toArray());

        // See the new line in a list of lines
        $this->get('/places')
            ->assertSee(htmlentities($place->name, ENT_QUOTES));
    }

//    /** @test */
//    function a_user_can_tag_their_bytes_with_lifelines() // Maybe do one for on creation, and one for adding later?
//    { // TODO-KGW not finished test. Remove of finish when you add a asynchronous tagging mechanism.
////        // A signed in user
////        $this->signIn();
////
////        // with a byte
////        $byte = create('App\Byte', ['user_id' => auth()->id()]);
////        $line1 = create('App\Line', ['name' => 'Test1', 'user_id' => auth()->id()]);
////        $line2 = create('App\Line', ['name' => 'Test2', 'user_id' => auth()->id()]);
////
////        $this->put('/bytes/' . $byte->id, ['name' => [1,2]]);
////
////        $this->get('/bytes/' . $byte->id)
////            ->assertSee($line1->name)
////            ->assertSee($line2->name);
//    }

    // validation tests
    /** @test */
    function a_place_requires_a_name()
    {
        $this->addPlace(['name' => null])
            ->assertSessionHasErrors('name');
    }

    /** @test */
    function a_place_requires_a_unique_name()
    {
        $this->addPlace(['name' => 'Test']);

        $this->addPlace(['name' => 'Test'])
            ->assertSessionHasErrors('name');
    }

    public function addPlace($overrides = [])
    {
        $this->withExceptionHandling()->signIn();

        $place = make('App\Place', $overrides);

        return $this->post('/places', $place->toArray());
    }
}
