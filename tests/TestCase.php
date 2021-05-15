<?php

namespace Tests;

use App\Models\User\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
    * @var User
    */
    protected User $user;

    /**
    * A lot of testing is going to be requiring a user, to which we are going to want to create a user and attach it to
    * the testing process (rather than re-creating user models per test we can create one).
    *
    * @return void
    */
    protected function createAuthenticatedUserForTestingPurposes()
    {
        $this->user = User::factory()->create();
    }

    /**
    * rather than applying this logic to each specific test case, we are going to want to destroy the user in question
    * when the object is in the process of destructing... we're going to let go of the user from the database in
    * question
    *
    * @return void
    */
    public function __destruct()
    {
        if ($this->user !== null)
            $this->user->delete();
    }
}
