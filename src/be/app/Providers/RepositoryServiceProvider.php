<?php

namespace App\Providers;

use App\Interfaces\AuditLogRepositoryInterface;
use App\Interfaces\CompanyRepositoryInterface;
use App\Interfaces\ProjectRepositoryInterface;
use App\Interfaces\TaskRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;
use App\Policies\AuditLogPolicy;
use App\Policies\CompanyPolicy;
use App\Policies\ProjectPolicy;
use App\Policies\TaskPolicy;
use App\Policies\UserPolicy;
use App\Repository\AuditLogRepository;
use App\Repository\CompanyRepository;
use App\Repository\ProjectRepository;
use App\Repository\TaskRepository;
use App\Repository\UserRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(CompanyRepositoryInterface::class, CompanyRepository::class);
        $this->app->bind(ProjectRepositoryInterface::class, ProjectRepository::class);
        $this->app->bind(TaskRepositoryInterface::class, TaskRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(AuditLogRepositoryInterface::class, AuditLogRepository::class);
    }

    public function boot(): void
    {
        $gate = $this->app->make(\Illuminate\Contracts\Auth\Access\Gate::class);

        $gate->define('view-company', [CompanyPolicy::class, 'view']);
        $gate->define('view-any-company', [CompanyPolicy::class, 'viewAny']);
        $gate->define('create-company', [CompanyPolicy::class, 'create']);
        $gate->define('update-company', [CompanyPolicy::class, 'update']);
        $gate->define('delete-company', [CompanyPolicy::class, 'delete']);
        $gate->define('restore-company', [CompanyPolicy::class, 'restore']);
        $gate->define('force-delete-company', [CompanyPolicy::class, 'forceDelete']);

        $gate->define('view-project', [ProjectPolicy::class, 'view']);
        $gate->define('view-any-project', [ProjectPolicy::class, 'viewAny']);
        $gate->define('create-project', [ProjectPolicy::class, 'create']);
        $gate->define('update-project', [ProjectPolicy::class, 'update']);
        $gate->define('delete-project', [ProjectPolicy::class, 'delete']);
        $gate->define('restore-project', [ProjectPolicy::class, 'restore']);
        $gate->define('force-delete-project', [ProjectPolicy::class, 'forceDelete']);

        $gate->define('view-task', [TaskPolicy::class, 'view']);
        $gate->define('view-any-task', [TaskPolicy::class, 'viewAny']);
        $gate->define('create-task', [TaskPolicy::class, 'create']);
        $gate->define('update-task', [TaskPolicy::class, 'update']);
        $gate->define('delete-task', [TaskPolicy::class, 'delete']);
        $gate->define('restore-task', [TaskPolicy::class, 'restore']);
        $gate->define('force-delete-task', [TaskPolicy::class, 'forceDelete']);

        $gate->define('view-user', [UserPolicy::class, 'view']);
        $gate->define('view-any-user', [UserPolicy::class, 'viewAny']);
        $gate->define('create-user', [UserPolicy::class, 'create']);
        $gate->define('update-user', [UserPolicy::class, 'update']);
        $gate->define('delete-user', [UserPolicy::class, 'delete']);
        $gate->define('restore-user', [UserPolicy::class, 'restore']);
        $gate->define('force-delete-user', [UserPolicy::class, 'forceDelete']);

        $gate->define('view-audit-log', [AuditLogPolicy::class, 'view']);
        $gate->define('view-any-audit-log', [AuditLogPolicy::class, 'viewAny']);
    }
}
