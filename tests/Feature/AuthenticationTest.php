<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class AuthenticationTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    function properly_formed_api_authentication_requests_receive_session_ids()
    {
//        $this->post('/api/v1/signin', [
//            'username' => 'kyle',
//            'password' => 'password'
//        ]);
    }
}
