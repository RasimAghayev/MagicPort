<?php

namespace Tests\Feature\Project;

use App\Models\Company;
use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProjectTest extends TestCase
{
    use RefreshDatabase;

    private function authHeaders(User $user): array
    {
        return ['Authorization' => 'Bearer ' . $user->createToken('test')->plainTextToken];
    }

    public function test_user_can_list_projects(): void
    {
        $user = User::factory()->create();
        Company::factory()->create(['code' => 'C001']);
        Project::factory()->count(3)->create(['company_code' => 'C001']);

        $response = $this->withHeaders($this->authHeaders($user))
            ->getJson('/api/v1/projects');

        $response->assertStatus(200);
        $response->assertJsonCount(3, 'data');
    }

    public function test_user_can_create_project(): void
    {
        $user = User::factory()->create();
        Company::factory()->create(['code' => 'C001']);

        $response = $this->withHeaders($this->authHeaders($user))
            ->postJson('/api/v1/projects', [
                'code' => 'P001',
                'name' => 'Test Project',
                'company_code' => 'C001',
                'budget' => 10000.00,
                'is_active' => true,
            ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('projects', ['code' => 'P001']);
    }

    public function test_user_can_show_project(): void
    {
        $user = User::factory()->create();
        $project = Project::factory()->create(['code' => 'P001', 'company_code' => 'C001']);

        $response = $this->withHeaders($this->authHeaders($user))
            ->getJson('/api/v1/projects/P001');

        $response->assertStatus(200);
        $response->assertJson(['data' => ['code' => 'P001']]);
    }

    public function test_user_can_update_project(): void
    {
        $user = User::factory()->create();
        $project = Project::factory()->create(['code' => 'P001', 'company_code' => 'C001']);

        $response = $this->withHeaders($this->authHeaders($user))
            ->putJson('/api/v1/projects/P001', [
                'name' => 'Updated Project',
            ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('projects', ['code' => 'P001', 'name' => 'Updated Project']);
    }

    public function test_user_can_delete_project(): void
    {
        $user = User::factory()->create();
        $project = Project::factory()->create(['code' => 'P001', 'company_code' => 'C001']);

        $response = $this->withHeaders($this->authHeaders($user))
            ->deleteJson('/api/v1/projects/P001');

        $response->assertStatus(204);
        $this->assertSoftDeleted('projects', ['code' => 'P001']);
    }

    public function test_user_can_restore_project(): void
    {
        $user = User::factory()->create();
        $project = Project::factory()->create(['code' => 'P001', 'company_code' => 'C001']);
        $project->delete();

        $response = $this->withHeaders($this->authHeaders($user))
            ->postJson('/api/v1/projects/P001/restore');

        $response->assertStatus(200);
        $this->assertDatabaseHas('projects', ['code' => 'P001']);
    }

    public function test_user_can_force_delete_project(): void
    {
        $user = User::factory()->create();
        $project = Project::factory()->create(['code' => 'P001', 'company_code' => 'C001']);
        $project->delete();

        $response = $this->withHeaders($this->authHeaders($user))
            ->deleteJson('/api/v1/projects/P001/force-delete');

        $response->assertStatus(204);
        $this->assertDatabaseMissing('projects', ['code' => 'P001']);
    }
}
