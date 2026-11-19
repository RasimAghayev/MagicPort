<?php

namespace Tests\Feature\Task;

use App\Models\Company;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    private function authHeaders(User $user): array
    {
        return ['Authorization' => 'Bearer ' . $user->createToken('test')->plainTextToken];
    }

    public function test_user_can_list_tasks(): void
    {
        $user = User::factory()->create();
        Company::factory()->create(['code' => 'C001']);
        Project::factory()->create(['code' => 'P001', 'company_code' => 'C001']);
        Task::factory()->count(3)->create(['company_code' => 'C001', 'project_code' => 'P001']);

        $response = $this->withHeaders($this->authHeaders($user))
            ->getJson('/api/v1/tasks');

        $response->assertStatus(200);
        $response->assertJsonCount(3, 'data');
    }

    public function test_user_can_create_task(): void
    {
        $user = User::factory()->create();
        Company::factory()->create(['code' => 'C001']);
        Project::factory()->create(['code' => 'P001', 'company_code' => 'C001']);

        $response = $this->withHeaders($this->authHeaders($user))
            ->postJson('/api/v1/tasks', [
                'code' => 'T001',
                'name' => 'Test Task',
                'company_code' => 'C001',
                'project_code' => 'P001',
                'priority' => 3,
                'is_active' => true,
            ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('tasks', ['code' => 'T001']);
    }

    public function test_user_can_show_task(): void
    {
        $user = User::factory()->create();
        $task = Task::factory()->create(['code' => 'T001', 'company_code' => 'C001', 'project_code' => 'P001']);

        $response = $this->withHeaders($this->authHeaders($user))
            ->getJson('/api/v1/tasks/T001');

        $response->assertStatus(200);
        $response->assertJson(['data' => ['code' => 'T001']]);
    }

    public function test_user_can_update_task(): void
    {
        $user = User::factory()->create();
        $task = Task::factory()->create(['code' => 'T001', 'company_code' => 'C001', 'project_code' => 'P001']);

        $response = $this->withHeaders($this->authHeaders($user))
            ->putJson('/api/v1/tasks/T001', [
                'name' => 'Updated Task',
            ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('tasks', ['code' => 'T001', 'name' => 'Updated Task']);
    }

    public function test_user_can_delete_task(): void
    {
        $user = User::factory()->create();
        $task = Task::factory()->create(['code' => 'T001', 'company_code' => 'C001', 'project_code' => 'P001']);

        $response = $this->withHeaders($this->authHeaders($user))
            ->deleteJson('/api/v1/tasks/T001');

        $response->assertStatus(204);
        $this->assertSoftDeleted('tasks', ['code' => 'T001']);
    }

    public function test_user_can_restore_task(): void
    {
        $user = User::factory()->create();
        $task = Task::factory()->create(['code' => 'T001', 'company_code' => 'C001', 'project_code' => 'P001']);
        $task->delete();

        $response = $this->withHeaders($this->authHeaders($user))
            ->postJson('/api/v1/tasks/T001/restore');

        $response->assertStatus(200);
        $this->assertDatabaseHas('tasks', ['code' => 'T001']);
    }

    public function test_user_can_force_delete_task(): void
    {
        $user = User::factory()->create();
        $task = Task::factory()->create(['code' => 'T001', 'company_code' => 'C001', 'project_code' => 'P001']);
        $task->delete();

        $response = $this->withHeaders($this->authHeaders($user))
            ->deleteJson('/api/v1/tasks/T001/force-delete');

        $response->assertStatus(204);
        $this->assertDatabaseMissing('tasks', ['code' => 'T001']);
    }
}
