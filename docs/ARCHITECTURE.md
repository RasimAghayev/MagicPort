# Architecture — MagicPort

## Overview

MagicPort is a Laravel 12 API application providing CRUD over a Company/Project/Task/User domain with Sanctum-based authentication. The backend (`src/be/`) exposes a versioned REST API (`/api/v1/*`) with a clean layered architecture: **Controller → Service → Repository → Model**.

## Directory structure

```
MagicPort/
├── php.dockerfile              # PHP 8.5.12-FPM base image with Laravel extensions
├── nginx.dockerfile            # nginx with default site config
├── docker-compose.yml          # Multi-service orchestration (php, nginx, mysql, artisan, phpunit, composer)
├── Makefile                    # build/test/verify/up/down targets
├── .github/workflows/ci.yml    # GitHub Actions CI pipeline
├── src/be/                     # Laravel backend application
│   ├── app/
│   │   ├── Classes/ApiResponseClass.php   # Standardized JSON responses
│   │   ├── Exceptions/Handler.php         # Global exception handler
│   │   ├── Http/
│   │   │   ├── Controllers/Controller.php # Base controller with response helpers
│   │   │   ├── Controllers/V1/            # Versioned API controllers
│   │   │   │   ├── Auth/AuthController.php
│   │   │   │   ├── Company/CompanyController.php
│   │   │   │   ├── Contract/ContractController.php
│   │   │   │   ├── Invoice/InvoiceController.php
│   │   │   │   ├── Project/ProjectController.php
│   │   │   │   ├── Task/TaskController.php
│   │   │   │   ├── Ticket/TicketController.php
│   │   │   │   └── User/UserController.php
│   │   │   ├── Requests/V1/               # Form request validation
│   │   │   │   ├── Auth/{Login,Register}Request.php
│   │   │   │   ├── Company/{Store,Update}CompanyRequest.php
│   │   │   │   ├── Contract/{Store,Update}ContractRequest.php
│   │   │   │   ├── Invoice/{Store,Update}InvoiceRequest.php
│   │   │   │   ├── Project/{Store,Update}ProjectRequest.php
│   │   │   │   ├── Task/{Store,Update}TaskRequest.php
│   │   │   │   ├── Ticket/{Store,Update}TicketRequest.php
│   │   │   │   └── User/{Store,Update}UserRequest.php
│   │   │   └── Resources/V1/              # API resources
│   │   │       ├── Auth/TokenResource.php
│   │   │       ├── Company/{CompanyResource,CompanyCollection}.php
│   │   │       ├── Contract/{ContractResource,ContractCollection}.php
│   │   │       ├── Invoice/{InvoiceResource,InvoiceCollection}.php
│   │   │       ├── Project/{ProjectResource,ProjectCollection}.php
│   │   │       ├── Task/{TaskResource,TaskCollection}.php
│   │   │       ├── Ticket/{TicketResource,TicketCollection}.php
│   │   │       └── User/{UserResource,UserCollection}.php
│   │   ├── Repositories/V1/               # Data access layer
│   │   │   ├── RepositoryInterface.php
│   │   │   ├── Company/{CompanyRepository,CompanyRepositoryInterface}.php
│   │   │   ├── Contract/{ContractRepository,ContractRepositoryInterface}.php
│   │   │   ├── Invoice/{InvoiceRepository,InvoiceRepositoryInterface}.php
│   │   │   ├── Project/{ProjectRepository,ProjectRepositoryInterface}.php
│   │   │   ├── Task/{TaskRepository,TaskRepositoryInterface}.php
│   │   │   ├── Ticket/{TicketRepository,TicketRepositoryInterface}.php
│   │   │   └── User/{UserRepository,UserRepositoryInterface}.php
│   │   ├── Services/V1/                   # Business logic layer
│   │   │   ├── Auth/{AuthService,AuthServiceInterface}.php
│   │   │   ├── Company/{CompanyService,CompanyServiceInterface}.php
│   │   │   ├── Contract/{ContractService,ContractServiceInterface}.php
│   │   │   ├── Invoice/{InvoiceService,InvoiceServiceInterface}.php
│   │   │   ├── Project/{ProjectService,ProjectServiceInterface}.php
│   │   │   ├── Task/{TaskService,TaskServiceInterface}.php
│   │   │   ├── Ticket/{TicketService,TicketServiceInterface}.php
│   │   │   └── User/{UserService,UserServiceInterface}.php
│   │   ├── Models/
│   │   │   ├── V1/Company.php      (string PK: code)
│   │   │   ├── V1/Contract.php     (string PK: code)
│   │   │   ├── V1/Invoice.php      (string PK: code)
│   │   │   ├── V1/Project.php      (string PK: code)
│   │   │   ├── V1/Task.php         (string PK: code)
│   │   │   ├── V1/Ticket.php       (string PK: code)
│   │   │   └── User.php            (int PK: id)
│   │   ├── Providers/RepositoryServiceProvider.php  # DI bindings
│   │   └── Providers/AppServiceProvider.php
│   ├── routes/api.php              # v1 API routes
│   ├── database/migrations/        # companies, projects, tasks, users
│   ├── database/factories/         # Model factories
│   └── tests/                      # Feature + Unit tests
│       ├── Feature/{Auth,Company,Project,Task,User}/
│       └── Unit/Services/
└── src/fe/                         # Frontend placeholder
```

## Architecture pattern

Layered monolithic API (single deployable unit):

- **Routes** → `routes/api.php` → Controllers (scoped by `code` for company/project/task)
- **HTTP layer** — Controllers delegate to Services, return standardized JSON via `ApiResponseClass`
- **Service layer** — All modules use `ServiceInterface` + implementation; business logic + transactions
- **Repository layer** — All modules use `RepositoryInterface` + implementation; Eloquent data access
- **Data access** — Eloquent ORM with `Company`, `Project`, `Task`, `User` models
- **Response** — `ApiResponseClass` standardizes success/error JSON responses
- **Validation** — FormRequest classes for every write operation

## Module patterns

| Module | Primary Key | Pattern | Auth |
|--------|------------|---------|------|
| Company | `code` (string) | Controller → Service → Repository | Sanctum |
| Contract | `code` (string) | Controller → Service → Repository | Sanctum |
| Invoice | `code` (string) | Controller → Service → Repository | Sanctum |
| Project | `code` (string) | Controller → Service → Repository | Sanctum |
| Task | `code` (string) | Controller → Service → Repository | Sanctum |
| Ticket | `code` (string) | Controller → Service → Repository | Sanctum |
| User | `id` (int) | Controller → Service → Repository | Sanctum |
| Auth | n/a | Controller → Service | Sanctum tokens |

All modules support: index, store, show, update, destroy (soft delete), restore, force-delete.

## Boundaries

Single deployable unit (Laravel app + MySQL + nginx). All modules share the same codebase and database. Consistent layered pattern across all modules — no mixed architectures.

## External dependencies

- MySQL 8.4 (database)
- Packagist (Composer packages — Laravel 12, PHPUnit 12, Pint, Sanctum)
- nginx (web server)

## Standards applied

- PSR-4 autoloading (`App\` → `app/`)
- Laravel conventions (directory layout, config naming, migration naming)
- Conventional Commits (`feat:`, `fix:`, `refactor:`)
- String primary keys for company/project/task (`code` field)
- Soft deletes on all domain tables
