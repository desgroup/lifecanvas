<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class PeopleTagBytesTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    function unauthenticated_users_cannot_see_the_a_people_list()
    {
        $this->withExceptionHandling()
            ->get('/people')
            ->assertRedirect('login');
    }

    /** @test */
    function authenticated_users_can_see_a_list_of_their_people()
    {
        $this->signIn();

        $person = create('App\Person', ['user_id' => auth()->id()]);
        $person_otherUser = create('App\Person', ['user_id' => 2]);

        $this->get('/people')
            ->assertSee($person->name)
            ->assertDontSee($person_otherUser->name);
    }

    /** @test */
    function authenticated_users_can_view_bytes_by_people()
    {
        // Authenticate a user
        $this->signIn();

        // With bytes with places
        $personFiltered = create('App\Person', ['name' => 'Test1', 'user_id' => auth()->id()]);
        $personNotFiltered = create('App\Person', ['name' => 'Test2', 'user_id' => auth()->id()]);

        $byteToSee = factory('App\Byte')->create(['user_id' => auth()->id()]);
        $byteToSee->people()->attach($personFiltered);
        $byteToNotSee = factory('App\Byte')->create(['user_id' => auth()->id()]);
        $byteToNotSee->people()->attach($personNotFiltered);

        // Go to a page filtered by one of the places
        // The users sees a byte associated with that place
        // And doesn't see a byte not associated with that place
        $this->get('/people/' . $personFiltered->id)
            ->assertSee($byteToSee->title)
            ->assertDontSee($byteToNotSee->title);
    }

    /** @test */
    function unauthenticated_users_cannot_see_the_create_person_page()
    {
        $this->withExceptionHandling()
            ->get('/people/create')
            ->assertRedirect('login');
    }

    /** @test */
    function authenticated_users_can_add_people()
    {
        // Authenticate a user
        $this->signIn();

        // Go to lines create page and see the form
        $this->get('/people/create')
            ->assertSee('Add a Person');

        // Build a line
        $person = make('App\Person');

        // Submit a line
        // See the new line in a list of lines
        $this->post('/people', $person->toArray());

        // See the new line in a list of lines
        $this->get('/people')
            ->assertSee($person->name);
    }

    // validation tests
    /** @test */
    function a_person_requires_a_name()
    {
        $this->addPerson(['name' => null])
            ->assertSessionHasErrors('name');
    }

    /** @test */
    function a_person_requires_a_unique_name()
    {
        $this->addPerson(['name' => 'Test']);

        $this->addPerson(['name' => 'Test'])
            ->assertSessionHasErrors('name');
    }

    public function addPerson($overrides = [])
    {
        $this->withExceptionHandling()->signIn();

        $place = make('App\Person', $overrides);

        return $this->post('/people', $place->toArray());
    }
}
