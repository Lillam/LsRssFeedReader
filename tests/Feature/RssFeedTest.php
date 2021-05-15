<?php

namespace Tests\Feature;

use Tests\TestCase;

class RssFeedTest extends TestCase
{
    /**
    * We are going to be needing to test whether or not the user is able to attempt to subscribe to a feed and have the
    * system redirect the user back to the dashboard for seeing what the feed was.
    *
    * @test
    * @return void
    */
    public function testSubscribeToRssFeedShouldRedirect()
    {
        $this->createAuthenticatedUserForTestingPurposes();

        $response = $this->post(route('login'), [
            'username' => $this->user->username,
            'password' => 'password'
        ]);

        $this->assertAuthenticated();

        $response->assertRedirect(route('dashboard'));

        $this->get(route('subscribe'))
             ->assertRedirect(route('dashboard'));
    }

    // todo (Potential ways we could improve the testing in this regard)
    //  we could potentially test if the user that has been authenticated is able to do some of the following:
    //  - subscribe to a feed and be redirected with a message that alerts the user they need to enter an appropriate
    //    url
    //  - subscribe to a feed and see that the feed of which they had requested, is active on the page and has worked
}
