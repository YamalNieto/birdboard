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

    public function test_non_owners_may_not_invite_users()
    {
        $project = Project::factory()->create();

        $user = User::factory()->create();

        $this->authenticate($user)
            ->post($project->path() . '/invitations')
            ->assertStatus(403);
    }

    public function test_a_project_owner_can_invite_an_user()
    {
        $project = Project::factory()->create();

        $userToInvite = User::factory()->create();

        $this->authenticate($project->owner)->post($project->path() . '/invitations', [
            'email' => $userToInvite->email
        ])
        ->assertRedirect($project->path());

        $this->assertTrue($project->members->contains($userToInvite));
    }

    public function test_the_invited_email_address_must_be_associated_with_a_valid_birdboard_account()
    {
        $project = Project::factory()->create();

        $userToInvite = User::factory()->create();

        $this->authenticate($project->owner)
            ->post($project->path() . '/invitations', [
                'email' => 'notauser@example.com'
            ])
            ->assertSessionHasErrors([
                'email' => 'The user you are inviting must have a Birdboard account.'
            ]);
    }
    public function test_invited_users_may_update_project_details()
    {
        $this->withoutExceptionHandling();

        $project = Project::factory()->create();

        $project->invite($newUser = User::factory()->create());

        $this->authenticate($newUser);

        $this->post($project->path() . '/tasks', $task = ['body' => 'Foo task']);

        $this->assertDatabaseHas('tasks', $task);
    }
}
