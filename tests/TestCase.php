<?php

namespace Tests;

use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function createUser()
    {
        return User::factory()->create();
    }

    public function createProject()
    {
        return Project::factory()->create();
    }
}
