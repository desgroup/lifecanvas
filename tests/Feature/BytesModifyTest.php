<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use TimezonesTableSeeder;

class BytesModifyTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function an_unauthenticated_user_cannot_edit_a_byte()
    {
        $this->withExceptionHandling()
            ->get('/bytes/1/edit')
            ->assertRedirect('login');
    }

    /** @test */
    function an_authenticated_user_sees_an_editable_form_when_selecting_to_edit_a_byte_they_own()
    {
        $this->signIn();

        $seeder = new TimezonesTableSeeder();
        $seeder->run();

        $byte = create('App\Byte', ['user_id' => auth()->id()]);

        // Go the the byte edit page
        $response = $this->get('/bytes/' . $byte->id . '/edit');

        // Expect to see the two bytes
        $response->assertSee($byte->title);
        $response->assertSee($byte->story);
        $response->assertSee('Update Byte');
    }

    /** @test */
    function unauthorized_users_may_not_update_bytes ()
    {
        $this->withExceptionHandling();

        $this->signIn();

        $byte = create('App\Byte', ['user_id' => create('App\User')->id]);

        $this->patch($byte->path(), [
            'title' => 'Changed',
            'story' => 'Changed story.'
        ])->assertStatus(403);
    }

    /** @test */
    function a_byte_can_be_updated_by_its_creator ()
    {
        $this->signIn();

        $seeder = new TimezonesTableSeeder();
        $seeder->run();

        $byte = create('App\Byte', ['user_id' => auth()->id()]);

        $this->patch($byte->path(), [
           'title' => 'Changed',
           'story' => 'Changed story.',
            'privacy' => 1
        ]);

        tap($byte->fresh(), function($byte) {
            $this->assertEquals('Changed', $byte->title);
            $this->assertEquals('Changed story.', $byte->story);
        });
    }

    /** @test */
    function a_byte_requires_a_title_and_privacy_to_be_updated ()
    {
        $this->withExceptionHandling();

        $this->signIn();

        $byte = create('App\Byte', ['user_id' => auth()->id()]);

        $this->patch($byte->path(), [
            'title' => 'Changed'
        ])->assertSessionHasErrors('privacy');

        $this->patch($byte->path(), [
            'privacy' => 1
        ])->assertSessionHasErrors('title');
    }

//    /** @test */
//    function a_byte_requires_a_privacy_setting_to_be_updated ()
//    {
//        $this->withExceptionHandling();
//
//        $this->signIn();
//
//        $byte = create('App\Byte', ['user_id' => auth()->id()]);
//
//        $this->patch($byte->path(), [
//            'story' => 'Changed story.'
//        ])->assertSessionHasErrors('privacy');
//    }
}
