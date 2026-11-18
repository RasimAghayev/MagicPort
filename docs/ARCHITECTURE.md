# Architecture — MagicPort

## Overview

MagicPort is a Laravel 11 API application providing CRUD over a Company/Project/Task/User domain. The backend (`src/be/`) exposes a versioned REST API (`/api/v1/*`) with repository/service abstraction for the Company module and direct Eloquent for simpler CRUD modules (Project, Task, User).

## Directory structure

```
MagicPort/
├── php.dockerfile              # PHP 8.3-FPM base image with Laravel extensions
├── nginx.dockerfile            # nginx with default site config
├── docker-compose.yml          # Multi-service orchestration
├── Makefile                    # build/test/verify/up/down targets
├── .github/workflows/ci.yml    # GitHub Actions CI pipeline
├── src/be/                     # Laravel backend application
│   ├── app/
│   │   ├── Classes/ApiResponseClass.php   # Standardized JSON responses
│   │   ├── Enums/                         # DefaultStatus, UserStatus, TaskStatus
│   │   ├── Filters/ApiFilter.php          # Base query filter
│   │   ├── Filters/V1/                    # TaskFilters, ProjectFilters
│   │   ├── Http/
│   │   │   ├── Controllers/
│   │   │   │   ├── V1/
│   │   │   │   │   ├── CompanyController.php
│   │   │   │   │   ├── ProjectController.php
│   │   │   │   │   ├── TaskController.php
│   │   │   │   │   ├── UserController.php
│   │   │   │   │   └── Company/                 # Company submodule
│   │   │   │   │   │       ├── Service/         # CompanyService + interface
│   │   │   │   │   │       ├── Repository/      # CompanyRepository + interface
│   │   │   │   │   │       ├── Filter/          # CompanyFilters
│   │   │   │   │   │       ├── Requests/        # Store/UpdateCompanyRequest
│   │   │   │   │   │       ├── Resources/       # Company*Resource + Collection
│   │   │   │   │   │       └── DTO/             # CompanyDTO
│   │   │   │   │   ├── Project/                 # ProjectController + requests/resources
│   │   │   │   │   ├── Task/                    # TaskController + requests/resources
│   │   │   │   └── UserController.php
│   │   ├── Models/
│   │   │   ├── V1/Company.php
│   │   │   ├── V1/Project.php
│   │   │   ├── V1/Task.php
│   │   │   └── User.php
│   │   ├── Providers/RepositoryServiceProvider.php
│   │   └── Middleware/SecurityHeaders.php
│   ├── routes/api.php               # v1 apiResource routes
│   ├── database/migrations/         # companies, projects, tasks, company_user
│   └── tests/                       # Feature + Unit tests
└── src/fe/                        # Empty — frontend placeholder
```

## Architecture pattern

Layered monolithic API (single deployable unit):

- **Routes** → `routes/api.php` → `Route::apiResource('v1', ...)` for companies, projects, tasks, users
- **HTTP layer** — Controllers handle request/response, validation via FormRequest classes
- **Service layer** (Company only) — `CompanyService` orchestrates business logic via `CompanyDTO`
- **Repository layer** (Company only) — `CompanyRepository` wraps Eloquent `Company` model via `CompanyRepositoryInterface`
- **Data access** — Eloquent ORM with `Company`, `Project`, `Task`, `User` models
- **Response** — `ApiResponseClass` standardizes success/error JSON responses

## Module patterns

| Module | Pattern | Rationale |
|--------|---------|-----------|
| Company | Repository + Service + DTO | Core domain with relationships; ADR-0001/0002 |
| Project | Direct Eloquent + FormRequest | Simple CRUD; ADR-0003 (KISS/YAGNI) |
| Task | Direct Eloquent + FormRequest | Simple CRUD; ADR-0003 |
| User | Direct Eloquent + route model binding | Simple CRUD; ADR-0003/0004 |

## Boundaries

No module boundaries or bounded contexts. Single deployable unit (Laravel app + MySQL + nginx). Not a modular monolith — no real domain complexity to justify it yet.

## External dependencies

- MySQL (database)
- Packagist (Composer packages — Laravel 11, PHPUnit 11, Pint, PHPStan)
- nginx (web server)

## Diagrams

None yet — flows documented via ADRs in `docs/adr/`. Will be expanded in Phase 15.

## Standards applied

- PSR-4 autoloading (`App\` → `app/`)
- Laravel conventions (directory layout, config naming, migration naming)
- Conventional Commits (`feat:`, `fix:`, `refactor:`)
- Route model binding for `{project}`, `{task}`, `{user}` (ADR-0004)

## Decisions

See `docs/adr/`:
- ADR-0001 — Repository/Service pattern for Company module
- ADR-0002 — DTO pattern for company data transfer
- ADR-0003 — Direct Eloquent for Project/Task/User controllers
- ADR-0004 — Route model binding for User/Task/Project controllers
