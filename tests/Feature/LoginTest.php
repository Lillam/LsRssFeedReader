<?php

namespace Tests\Feature;

use Tests\TestCase;

class LoginTest extends TestCase
{
    /**
    * We're going to test to see whether or not the user is able to be logged in... this application is heavily reliant
    * on a user being signed in and thus we are going to assert that the user is able to be logged in.
    *
    * @test
    * @return void
    */
    public function testCanUserLoginUsingTheLoginForm()
    {
        $this->createAuthenticatedUserForTestingPurposes();

        $response = $this->post(route('login'), [
            'username' => $this->user->username,
            'password' => 'password'
        ]);

        $this->assertAuthenticated();

        $response->assertRedirect(route('dashboard'));
    }
}
