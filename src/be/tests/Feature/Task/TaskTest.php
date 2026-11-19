<?php

namespace Tests\Feature\Task;

use App\Models\V1\Company;
use App\Models\V1\Project;
use App\Models\V1\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_list_tasks(): void
    {
        $user = User::factory()->create();
        $company = Company::factory()->create(['user_id' => $user->id]);
        $project = Project::factory()->create([
            'company_code' => $company->code,
            'user_id'      => $user->id,
        ]);
        Task::factory()->count(3)->create([
            'project_code' => $project->code,
            'user_id'      => $user->id,
        ]);

        $response = $this->actingAs($user, 'sanctum')
            ->getJson('/api/v1/tasks');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data',
            'meta' => ['current_page', 'per_page', 'total', 'last_page'],
        ]);
        $response->assertJsonCount(3, 'data');
    }

    public function test_user_can_create_task(): void
    {
        $user = User::factory()->create();
        $company = Company::factory()->create(['user_id' => $user->id]);
        $project = Project::factory()->create([
            'company_code' => $company->code,
            'user_id'      => $user->id,
        ]);

        $response = $this->actingAs($user, 'sanctum')
            ->postJson('/api/v1/tasks', [
                'project_code' => $project->code,
                'user_id'      => $user->id,
                'title'        => 'Test Task',
                'code'         => 'TK001',
                'status'       => 'todo',
            ]);

        $response->assertStatus(201);
        $response->assertJson([
            'data' => [
                'title' => 'Test Task',
                'code'  => 'TK001',
                'status'=> 'todo',
            ],
        ]);

        $this->assertDatabaseHas('tasks', ['code' => 'TK001']);
    }

    public function test_user_can_show_task(): void
    {
        $user = User::factory()->create();
        $company = Company::factory()->create(['user_id' => $user->id]);
        $project = Project::factory()->create([
            'company_code' => $company->code,
            'user_id'      => $user->id,
        ]);
        $task = Task::factory()->create([
            'project_code' => $project->code,
            'user_id'      => $user->id,
            'code'         => 'TK001',
            'title'        => 'Test Task',
        ]);

        $response = $this->actingAs($user, 'sanctum')
            ->getJson('/api/v1/tasks/TK001');

        $response->assertStatus(200);
        $response->assertJson([
            'data' => [
                'code'  => 'TK001',
                'title' => 'Test Task',
            ],
        ]);
    }

    public function test_user_can_update_task(): void
    {
        $user = User::factory()->create();
        $company = Company::factory()->create(['user_id' => $user->id]);
        $project = Project::factory()->create([
            'company_code' => $company->code,
            'user_id'      => $user->id,
        ]);
        $task = Task::factory()->create([
            'project_code' => $project->code,
            'user_id'      => $user->id,
            'code'         => 'TK001',
        ]);

        $response = $this->actingAs($user, 'sanctum')
            ->putJson('/api/v1/tasks/TK001', [
                'title' => 'Updated Task',
                'status'=> 'done',
            ]);

        $response->assertStatus(200);
        $response->assertJson([
            'data' => [
                'title' => 'Updated Task',
                'status'=> 'done',
            ],
        ]);
    }

    public function test_user_can_delete_task(): void
    {
        $user = User::factory()->create();
        $company = Company::factory()->create(['user_id' => $user->id]);
        $project = Project::factory()->create([
            'company_code' => $company->code,
            'user_id'      => $user->id,
        ]);
        $task = Task::factory()->create([
            'project_code' => $project->code,
            'user_id'      => $user->id,
            'code'         => 'TK001',
        ]);

        $response = $this->actingAs($user, 'sanctum')
            ->deleteJson('/api/v1/tasks/TK001');

        $response->assertStatus(204);
        $this->assertSoftDeleted('tasks', ['code' => 'TK001']);
    }

    public function test_user_can_restore_task(): void
    {
        $user = User::factory()->create();
        $company = Company::factory()->create(['user_id' => $user->id]);
        $project = Project::factory()->create([
            'company_code' => $company->code,
            'user_id'      => $user->id,
        ]);
        $task = Task::factory()->create([
            'project_code' => $project->code,
            'user_id'      => $user->id,
            'code'         => 'TK001',
        ]);
        $task->delete();

        $response = $this->actingAs($user, 'sanctum')
            ->postJson('/api/v1/tasks/TK001/restore');

        $response->assertStatus(200);
        $this->assertDatabaseHas('tasks', ['code' => 'TK001']);
    }

    public function test_user_can_force_delete_task(): void
    {
        $user = User::factory()->create();
        $company = Company::factory()->create(['user_id' => $user->id]);
        $project = Project::factory()->create([
            'company_code' => $company->code,
            'user_id'      => $user->id,
        ]);
        $task = Task::factory()->create([
            'project_code' => $project->code,
            'user_id'      => $user->id,
            'code'         => 'TK001',
        ]);
        $task->delete();

        $response = $this->actingAs($user, 'sanctum')
            ->deleteJson('/api/v1/tasks/TK001/force-delete');

        $response->assertStatus(204);
        $this->assertDatabaseMissing('tasks', ['code' => 'TK001']);
    }
}
