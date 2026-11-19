<?php

namespace Tests\Feature\Project;

use App\Models\V1\Company;
use App\Models\V1\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProjectTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_list_projects(): void
    {
        $user = User::factory()->create();
        $company = Company::factory()->create(['user_id' => $user->id]);
        Project::factory()->count(3)->create([
            'company_code' => $company->code,
            'user_id'      => $user->id,
        ]);

        $response = $this->actingAs($user, 'sanctum')
            ->getJson('/api/v1/projects');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data',
            'meta' => ['current_page', 'per_page', 'total', 'last_page'],
        ]);
        $response->assertJsonCount(3, 'data');
    }

    public function test_user_can_create_project(): void
    {
        $user = User::factory()->create();
        $company = Company::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user, 'sanctum')
            ->postJson('/api/v1/projects', [
                'company_code' => $company->code,
                'user_id'      => $user->id,
                'name'         => 'Test Project',
                'code'         => 'TP001',
                'status'       => 'active',
            ]);

        $response->assertStatus(201);
        $response->assertJson([
            'data' => [
                'name'      => 'Test Project',
                'code'      => 'TP001',
                'status'    => 'active',
            ],
        ]);

        $this->assertDatabaseHas('projects', ['code' => 'TP001']);
    }

    public function test_user_can_show_project(): void
    {
        $user = User::factory()->create();
        $company = Company::factory()->create(['user_id' => $user->id]);
        $project = Project::factory()->create([
            'company_code' => $company->code,
            'user_id'      => $user->id,
            'code'         => 'TP001',
            'name'         => 'Test Project',
        ]);

        $response = $this->actingAs($user, 'sanctum')
            ->getJson('/api/v1/projects/TP001');

        $response->assertStatus(200);
        $response->assertJson([
            'data' => [
                'code' => 'TP001',
                'name' => 'Test Project',
            ],
        ]);
    }

    public function test_user_can_update_project(): void
    {
        $user = User::factory()->create();
        $company = Company::factory()->create(['user_id' => $user->id]);
        $project = Project::factory()->create([
            'company_code' => $company->code,
            'user_id'      => $user->id,
            'code'         => 'TP001',
        ]);

        $response = $this->actingAs($user, 'sanctum')
            ->putJson('/api/v1/projects/TP001', [
                'name'  => 'Updated Project',
                'status'=> 'completed',
            ]);

        $response->assertStatus(200);
        $response->assertJson([
            'data' => [
                'name'  => 'Updated Project',
                'status'=> 'completed',
            ],
        ]);
    }

    public function test_user_can_delete_project(): void
    {
        $user = User::factory()->create();
        $company = Company::factory()->create(['user_id' => $user->id]);
        $project = Project::factory()->create([
            'company_code' => $company->code,
            'user_id'      => $user->id,
            'code'         => 'TP001',
        ]);

        $response = $this->actingAs($user, 'sanctum')
            ->deleteJson('/api/v1/projects/TP001');

        $response->assertStatus(204);
        $this->assertSoftDeleted('projects', ['code' => 'TP001']);
    }

    public function test_user_can_restore_project(): void
    {
        $user = User::factory()->create();
        $company = Company::factory()->create(['user_id' => $user->id]);
        $project = Project::factory()->create([
            'company_code' => $company->code,
            'user_id'      => $user->id,
            'code'         => 'TP001',
        ]);
        $project->delete();

        $response = $this->actingAs($user, 'sanctum')
            ->postJson('/api/v1/projects/TP001/restore');

        $response->assertStatus(200);
        $this->assertDatabaseHas('projects', ['code' => 'TP001']);
    }

    public function test_user_can_force_delete_project(): void
    {
        $user = User::factory()->create();
        $company = Company::factory()->create(['user_id' => $user->id]);
        $project = Project::factory()->create([
            'company_code' => $company->code,
            'user_id'      => $user->id,
            'code'         => 'TP001',
        ]);
        $project->delete();

        $response = $this->actingAs($user, 'sanctum')
            ->deleteJson('/api/v1/projects/TP001/force-delete');

        $response->assertStatus(204);
        $this->assertDatabaseMissing('projects', ['code' => 'TP001']);
    }
}
