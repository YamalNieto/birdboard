<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TriggerActivityTest extends TestCase
{
    use RefreshDatabase;

    public function test_creating_a_project()
    {
        $project = Project::factory()->create();

        $this->assertCount(1, $project->activity);

        $this->assertEquals('created_project', $project->activity[0]->description);

        $this->assertNull($project->activity->last()->changes);
    }

    public function test_updating_a_project()
    {
        $project = Project::factory()->create();
        $originalTitle = $project->title;

        $project->update(['title' => 'Changed']);

        $last_activity = $project->activity->last();

        $this->assertCount(2, $project->activity);
        $this->assertEquals('updated_project', $last_activity->description);

        $expected = [
            'before' => ['title' => $originalTitle],
            'after' => ['title' => 'Changed']
        ];

        $this->assertEquals($expected, $last_activity->changes);
    }

    public function test_creating_a_new_task()
    {
        $project = Project::factory()->create();

        $project->addTask('Some task');

        $this->assertCount(2, $project->activity);
        $this->assertEquals('created_task', $project->activity->last()->description);
        $this->assertInstanceOf(Task::class, $project->activity->last()->subject);
    }

    public function test_completing_a_task()
    {
        $this->authenticate();

        $project = Project::factory()->create(['user_id' => auth()->id()]);

        $task = $project->addTask('Some task');

        $this->patch($task->path(), [
            'body' => 'foobar',
            'completed' => true
        ]);

        $this->assertCount(3, $project->activity);
        $this->assertEquals('completed_task', $project->activity->last()->description);
        $this->assertInstanceOf(Task::class, $project->activity->last()->subject);
    }

    public function test_uncompleting_a_task()
    {
        $this->authenticate();

        $project = Project::factory()->create(['user_id' => auth()->id()]);

        $task = $project->addTask('Some task');

        $this->patch($task->path(), [
            'body' => 'foobar',
            'completed' => true
        ]);

        $this->assertCount(3, $project->activity);

        $this->patch($task->path(), [
            'body' => 'foobar',
            'completed' => false
        ]);

        $project->refresh();

        $this->assertCount(4, $project->activity);
        $this->assertEquals('uncompleted_task', $project->activity->last()->description);
        $this->assertInstanceOf(Task::class, $project->activity->last()->subject);
    }

    public function test_deleting_a_task()
    {
        $this->authenticate();

        $project = Project::factory()->create(['user_id' => auth()->id()]);

        $task = $project->addTask('Some task');

        $task->delete();

        $this->assertCount(3, $project->activity);

        $this->assertEquals('deleted_task', $project->activity->last()->description);

    }

}
