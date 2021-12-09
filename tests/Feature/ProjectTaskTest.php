<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProjectTaskTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_cannot_add_tasks_to_projects()
    {
        $project = Project::factory()->create();

        $this->post($project->path() . '/tasks')->assertRedirect('login');
    }

    public function test_only_the_owner_of_a_project_may_add_tasks()
    {
        $this->authenticate();

        $project = Project::factory()->create();

        $this->post($project->path() . '/tasks', ['body' => 'Test task'])
            ->assertStatus(403);
    }

    public function test_only_the_owner_of_a_project_may_update_a_task()
    {
        $this->authenticate();

        $project = Project::factory()->create();

        $task = $project->addTask('test task');

        $this->patch($project->path() . '/tasks/' . $task->id, ['body' => 'changed'])
            ->assertStatus(403);

        $this->assertDatabaseMissing('tasks', ['body' => 'changed']);
    }

    public function test_a_project_can_have_tasks()
    {
        $this->withoutExceptionHandling();

        $this->authenticate();

        $project = Project::factory()->create(['user_id' => auth()->id()]);

        $this->post($project->path() . "/tasks", ['body' => 'Test task']);

        $this->get($project->path())
            ->assertSee('Test task');
    }

    public function test_a_task_requires_a_body()
    {
        $this->authenticate();

        $project = Project::factory()->create(['user_id' => auth()->id()]);

        $attributes = Task::factory()->raw(['body' => '']);

        $this->post($project->path() . '/tasks', $attributes)->assertSessionHasErrors('body');
    }

    public function test_a_task_can_be_updated()
    {
        $this->authenticate();

        $project = Project::factory()->create(['user_id' => auth()->id()]);

        $task = $project->addTask('Test task');

        $this->patch($project->path() . '/tasks/' . $task->id, [
            'body' => 'changed',
            'completed' => true
        ]);

        $this->assertDatabaseHas('tasks', [
            'body' => 'changed',
            'completed' => true
        ]);
    }
}
