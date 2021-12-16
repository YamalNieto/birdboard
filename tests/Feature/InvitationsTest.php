<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class InvitationsTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_project_can_invite_a_user()
    {
        $this->withoutExceptionHandling();

        $project = Project::factory()->create();

        $project->invite($newUser = User::factory()->create());

        $this->authenticate($newUser);

        $this->post($project->path() . '/tasks', $task = ['body' => 'Foo task']);

        $this->assertDatabaseHas('tasks', $task);
    }
}
