<?php

namespace App\Providers;

use App\Interfaces\AuditLogRepositoryInterface;
use App\Http\Resources\V1\Company\CompanyResource;
use App\Http\Resources\V1\Contract\ContractResource;
use App\Http\Resources\V1\Invoice\InvoiceResource;
use App\Http\Resources\V1\Project\ProjectResource;
use App\Http\Resources\V1\Task\TaskResource;
use App\Http\Resources\V1\Ticket\TicketResource;
use App\Http\Resources\V1\User\UserResource;
use App\Repositories\V1\Company\CompanyRepository;
use App\Repositories\V1\Company\CompanyRepositoryInterface;
use App\Repositories\V1\Contract\ContractRepository;
use App\Repositories\V1\Contract\ContractRepositoryInterface;
use App\Repositories\V1\Invoice\InvoiceRepository;
use App\Repositories\V1\Invoice\InvoiceRepositoryInterface;
use App\Repositories\V1\Project\ProjectRepository;
use App\Repositories\V1\Project\ProjectRepositoryInterface;
use App\Repositories\V1\Task\TaskRepository;
use App\Repositories\V1\Task\TaskRepositoryInterface;
use App\Repositories\V1\Ticket\TicketRepository;
use App\Repositories\V1\Ticket\TicketRepositoryInterface;
use App\Repositories\V1\User\UserRepository;
use App\Repositories\V1\User\UserRepositoryInterface;
use App\Repository\AuditLogRepository;
use App\Services\V1\Auth\AuthService;
use App\Services\V1\Auth\AuthServiceInterface;
use App\Services\V1\Company\CompanyService;
use App\Services\V1\Company\CompanyServiceInterface;
use App\Services\V1\Contract\ContractService;
use App\Services\V1\Contract\ContractServiceInterface;
use App\Services\V1\Invoice\InvoiceService;
use App\Services\V1\Invoice\InvoiceServiceInterface;
use App\Services\V1\Project\ProjectService;
use App\Services\V1\Project\ProjectServiceInterface;
use App\Services\V1\Task\TaskService;
use App\Services\V1\Task\TaskServiceInterface;
use App\Services\V1\Ticket\TicketService;
use App\Services\V1\Ticket\TicketServiceInterface;
use App\Services\V1\User\UserService;
use App\Services\V1\User\UserServiceInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Repositories
        $this->app->bind(AuditLogRepositoryInterface::class, AuditLogRepository::class);
        $this->app->bind(CompanyRepositoryInterface::class, CompanyRepository::class);
        $this->app->bind(ContractRepositoryInterface::class, ContractRepository::class);
        $this->app->bind(InvoiceRepositoryInterface::class, InvoiceRepository::class);
        $this->app->bind(ProjectRepositoryInterface::class, ProjectRepository::class);
        $this->app->bind(TaskRepositoryInterface::class, TaskRepository::class);
        $this->app->bind(TicketRepositoryInterface::class, TicketRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);

        // Services
        $this->app->bind(CompanyServiceInterface::class, CompanyService::class);
        $this->app->bind(ContractServiceInterface::class, ContractService::class);
        $this->app->bind(InvoiceServiceInterface::class, InvoiceService::class);
        $this->app->bind(ProjectServiceInterface::class, ProjectService::class);
        $this->app->bind(TaskServiceInterface::class, TaskService::class);
        $this->app->bind(TicketServiceInterface::class, TicketService::class);
        $this->app->bind(UserServiceInterface::class, UserService::class);
        $this->app->bind(AuthServiceInterface::class, AuthService::class);
    }

    public function boot(): void
    {
        //
    }
}
