<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ManageProjectsTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    public function test_guests_cannot_manage_projects()
    {
        $project = Project::factory()->create();

        $this->get('/projects')->assertRedirect('login');
        $this->get('/projects/create')->assertRedirect('login');
        $this->get($project->path() . '/edit')->assertRedirect('login');
        $this->get($project->path())->assertRedirect('login');
        $this->post('/projects', $project->toArray())->assertRedirect('login');
    }
    public function test_guests_cannot_create_project()
    {
        $attributes = Project::factory()->raw();

        $this->post('/projects', $attributes)->assertRedirect('login');
    }

    public function test_guests_cannot_view_projects()
    {
        $this->get('/projects')->assertRedirect('login');
    }

    public function test_guests_cannot_view_projects_creation()
    {
        $this->get('/projects/create')->assertRedirect('login');
    }

    public function test_guests_cannot_view_a_single_project()
    {
        $project = Project::factory()->create();

        $this->get($project->path())->assertRedirect('login');
    }

    public function test_a_user_can_create_a_project()
    {
        $this->withoutExceptionHandling();

        $this->authenticate();

        $this->get('/projects/create')->assertStatus(200);

        $attributes = [
            'title' => $this->faker->sentence,
            'description' => $this->faker->sentence,
            'notes' => 'General notes here.'
        ];

        $response = $this->post('/projects', $attributes);

        $project = Project::where($attributes)->first();

        $response->assertRedirect($project->path());

        $this->assertDatabaseHas('projects', $attributes);

        $this->get($project->path())
            ->assertSee($attributes['title'])
            ->assertSee($attributes['description'])
            ->assertSee($attributes['notes']);
    }

    public function test_a_user_can_see_all_projects_they_have_been_invited_to_on_their_dashboard()
    {
        $this->authenticate($newUser = User::factory()->create());

        $project = Project::factory()->create();

        $project->invite($newUser);

        $this->get('/projects')
            ->assertSee($project->title);
    }

    public function test_unauthorized_users_cannot_delete_a_project()
    {
        $project = Project::factory()->create();

        $this->delete($project->path())->assertRedirect('/login');

        $this->authenticate();

        $this->delete($project->path())->assertStatus(403);
    }

    public function test_a_user_can_delete_a_project()
    {
        $this->authenticate();

        $project = Project::factory()->create(['user_id' => auth()->id()]);

        $this->delete($project->path())->assertRedirect('/projects');

        $this->assertDatabaseMissing('projects', $project->only('id'));
    }

    public function test_a_user_can_update_a_project()
    {
        $this->authenticate();

        $project = Project::factory()->create(['user_id' => auth()->id()]);

        $this->patch($project->path(), [
            'title' => 'Changed',
            'description' => 'Changed',
            'notes' => 'Changed'
        ])->assertRedirect($project->path());

        $this->get($project->path().'/edit')->assertOk();

        $this->assertDatabaseHas('projects', ['notes' => 'Changed']);
    }

    public function test_a_user_can_update_a_project_general_notes(){
        $this->authenticate();

        $project = Project::factory()->create(['user_id' => auth()->id()]);

        $this->patch($project->path(), [
            'notes' => 'Changed'
        ]);

        $this->assertDatabaseHas('projects', ['notes' => 'Changed']);
    }

    public function test_a_user_can_view_their_project()
    {
        $this->authenticate();

        $this->withoutExceptionHandling();

        $project = Project::factory()->create(['user_id' => auth()->id()]);

        $this->get($project->path())
            ->assertSee($project->title)
            ->assertSee($project->description);
    }

    public function test_an_authenticated_user_cannot_view_the_projects_of_others()
    {
        $this->authenticate();

        $project = Project::factory()->create();

        $this->get($project->path())->assertStatus(403);
    }

    public function test_an_authenticated_user_cannot_update_the_projects_of_others()
    {
        $this->authenticate();

        $project = Project::factory()->create();

        $this->patch($project->path(), [])->assertStatus(403);
    }


    public function test_a_project_requires_a_title()
    {
        $this->authenticate();

        $attributes = Project::factory()->raw(['title' => '']);

        $this->post('/projects', $attributes)->assertSessionHasErrors('title');
    }
}
