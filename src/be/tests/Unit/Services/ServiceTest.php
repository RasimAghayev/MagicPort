<?php

namespace Tests\Unit\Services;

use App\Models\User;
use App\Models\V1\Company;
use App\Models\V1\Project;
use App\Models\V1\Task;
use App\Repositories\V1\Company\CompanyRepositoryInterface;
use App\Repositories\V1\Project\ProjectRepositoryInterface;
use App\Repositories\V1\Task\TaskRepositoryInterface;
use App\Repositories\V1\User\UserRepositoryInterface;
use App\Services\V1\Company\CompanyService;
use App\Services\V1\Project\ProjectService;
use App\Services\V1\Task\TaskService;
use App\Services\V1\User\UserService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_company_service_crud(): void
    {
        $user = User::factory()->create();
        $repo = $this->app->make(CompanyRepositoryInterface::class);
        $service = new CompanyService($repo);

        $company = $service->create([
            'code'   => 'TC001',
            'name'   => 'Test Company',
            'user_id'=> $user->id,
            'status' => 'active',
        ]);

        $this->assertEquals('Test Company', $company->name);
        $this->assertEquals('TC001', $company->code);

        $found = $service->findByCode('TC001');
        $this->assertNotNull($found);
        $this->assertEquals('Test Company', $found->name);

        $all = $service->all();
        $this->assertCount(1, $all->items());

        $updated = $service->update('TC001', ['name' => 'Updated']);
        $this->assertEquals('Updated', $updated->name);

        $restored = $service->restore('TC001');
        $this->assertNull($restored);

        $deleted = $service->delete('TC001');
        $this->assertTrue($deleted);
        $this->assertSoftDeleted('companies', ['code' => 'TC001']);
    }

    public function test_project_service_crud(): void
    {
        $user = User::factory()->create();
        $company = Company::factory()->create(['user_id' => $user->id]);
        $repo = $this->app->make(ProjectRepositoryInterface::class);
        $service = new ProjectService($repo);

        $project = $service->create([
            'code'         => 'TP001',
            'name'         => 'Test Project',
            'company_code' => $company->code,
            'user_id'      => $user->id,
            'status'       => 'active',
        ]);

        $this->assertEquals('Test Project', $project->name);
        $this->assertEquals('TP001', $project->code);

        $found = $service->findByCode('TP001');
        $this->assertNotNull($found);

        $updated = $service->update('TP001', ['name' => 'Updated Project']);
        $this->assertEquals('Updated Project', $updated->name);

        $deleted = $service->delete('TP001');
        $this->assertTrue($deleted);
    }

    public function test_task_service_crud(): void
    {
        $user = User::factory()->create();
        $company = Company::factory()->create(['user_id' => $user->id]);
        $project = Project::factory()->create([
            'company_code' => $company->code,
            'user_id'      => $user->id,
        ]);
        $repo = $this->app->make(TaskRepositoryInterface::class);
        $service = new TaskService($repo);

        $task = $service->create([
            'code'         => 'TK001',
            'title'        => 'Test Task',
            'project_code' => $project->code,
            'user_id'      => $user->id,
            'status'       => 'todo',
        ]);

        $this->assertEquals('Test Task', $task->title);
        $this->assertEquals('TK001', $task->code);

        $found = $service->findByCode('TK001');
        $this->assertNotNull($found);

        $updated = $service->update('TK001', ['status' => 'done']);
        $this->assertEquals('done', $updated->status);

        $deleted = $service->delete('TK001');
        $this->assertTrue($deleted);
    }

    public function test_user_service_crud(): void
    {
        $repo = $this->app->make(UserRepositoryInterface::class);
        $service = new UserService($repo);

        $user = $service->create([
            'name'     => 'Test User',
            'email'    => 'test@example.com',
            'password' => 'password123',
        ]);

        $this->assertEquals('Test User', $user->name);
        $this->assertEquals('test@example.com', $user->email);
        $this->assertTrue(password_verify('password123', $user->password));

        $found = $service->findByEmail('test@example.com');
        $this->assertNotNull($found);

        $updated = $service->update($user->id, ['name' => 'Updated User']);
        $this->assertEquals('Updated User', $updated->name);

        $deleted = $service->delete($user->id);
        $this->assertTrue($deleted);
    }
}
