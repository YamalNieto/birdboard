<?php

namespace Tests\Unit;

use App\Models\Project;
use App\Models\User;
use Tests\TestCase;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_user_has_projects()
    {
        $user = $this->createUser();

        $this->assertInstanceOf(Collection::class, $user->projects);
    }

    public function test_a_user_has_accessible_projects()
    {
        $user = $this->createUser();

        $this->authenticate($user);

        Project::factory()->create(['user_id' => auth()->id()]);

        $this->assertCount(1, $user->accessibleProjects());

        $sally = $this->createUser();
        $nick = $this->createUser();

        $project = Project::factory()->create(['user_id' => $sally->id]);

        $project->invite($nick);

        $this->assertCount(1, $user->accessibleProjects());

        $project->invite($user);

        $this->assertCount(2, $user->accessibleProjects());
    }
}
