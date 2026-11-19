<?php

namespace App\Providers;

use App\Http\Resources\V1\Company\CompanyResource;
use App\Http\Resources\V1\Project\ProjectResource;
use App\Http\Resources\V1\Task\TaskResource;
use App\Http\Resources\V1\User\UserResource;
use App\Repositories\V1\Company\CompanyRepository;
use App\Repositories\V1\Company\CompanyRepositoryInterface;
use App\Repositories\V1\Project\ProjectRepository;
use App\Repositories\V1\Project\ProjectRepositoryInterface;
use App\Repositories\V1\Task\TaskRepository;
use App\Repositories\V1\Task\TaskRepositoryInterface;
use App\Repositories\V1\User\UserRepository;
use App\Repositories\V1\User\UserRepositoryInterface;
use App\Services\V1\Auth\AuthService;
use App\Services\V1\Auth\AuthServiceInterface;
use App\Services\V1\Company\CompanyService;
use App\Services\V1\Company\CompanyServiceInterface;
use App\Services\V1\Project\ProjectService;
use App\Services\V1\Project\ProjectServiceInterface;
use App\Services\V1\Task\TaskService;
use App\Services\V1\Task\TaskServiceInterface;
use App\Services\V1\User\UserService;
use App\Services\V1\User\UserServiceInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Repositories
        $this->app->bind(CompanyRepositoryInterface::class, CompanyRepository::class);
        $this->app->bind(ProjectRepositoryInterface::class, ProjectRepository::class);
        $this->app->bind(TaskRepositoryInterface::class, TaskRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);

        // Services
        $this->app->bind(CompanyServiceInterface::class, CompanyService::class);
        $this->app->bind(ProjectServiceInterface::class, ProjectService::class);
        $this->app->bind(TaskServiceInterface::class, TaskService::class);
        $this->app->bind(UserServiceInterface::class, UserService::class);
        $this->app->bind(AuthServiceInterface::class, AuthService::class);
    }

    public function boot(): void
    {
        //
    }
}
