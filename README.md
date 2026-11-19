# MagicPort

Laravel 12 API backend with clean layered architecture — Company, Project, Task, User management with Sanctum authentication and RBAC.

## Architecture

Clean layered architecture: **Controller → Service → Repository → Model**

| Layer | Responsibility |
|-------|---------------|
| Controller | HTTP request/response, validation delegation |
| Service | Business logic, transaction boundaries |
| Repository | Data access, Eloquent queries |
| Model | Data structure, relationships |

## Domain Modules

- **Company** — CRUD with soft delete, restore, force-delete (scoped by `code`)
- **Project** — CRUD, belongs to Company, scoped by `code`
- **Task** — CRUD, belongs to Project, scoped by `code`, status workflow
- **User** — CRUD, authentication (login/register/logout/me) via Sanctum
- **Auth** — JWT-style token authentication with Sanctum

## API Endpoints

```
POST   /api/v1/auth/register     Register new user
POST   /api/v1/auth/login        Authenticate user
POST   /api/v1/auth/logout       Revoke token
GET    /api/v1/auth/me           Current user profile

GET    /api/v1/companies         List companies
POST   /api/v1/companies         Create company
GET    /api/v1/companies/{code}  Show company
PUT    /api/v1/companies/{code}  Update company
DELETE /api/v1/companies/{code}  Soft delete company
POST   /api/v1/companies/{code}/restore       Restore company
DELETE /api/v1/companies/{code}/force-delete  Force delete company

GET    /api/v1/projects          List projects
POST   /api/v1/projects          Create project
GET    /api/v1/projects/{code}   Show project
PUT    /api/v1/projects/{code}   Update project
DELETE /api/v1/projects/{code}   Soft delete project
POST   /api/v1/projects/{code}/restore       Restore project
DELETE /api/v1/projects/{code}/force-delete  Force delete project

GET    /api/v1/tasks             List tasks
POST   /api/v1/tasks             Create task
GET    /api/v1/tasks/{code}      Show task
PUT    /api/v1/tasks/{code}      Update task
DELETE /api/v1/tasks/{code}      Soft delete task
POST   /api/v1/tasks/{code}/restore       Restore task
DELETE /api/v1/tasks/{code}/force-delete  Force delete task

GET    /api/v1/users             List users
POST   /api/v1/users             Create user
GET    /api/v1/users/{id}        Show user
PUT    /api/v1/users/{id}        Update user
DELETE /api/v1/users/{id}        Soft delete user
POST   /api/v1/users/{id}/restore       Restore user
DELETE /api/v1/users/{id}/force-delete  Force delete user

GET    /check/health             Health check
GET    /check/db                 Database connectivity
```

## Installation

```shell
# Clone the repository
git clone https://github.com/RasimAghayev/MagicPort.git
cd MagicPort

# Copy environment example
cp src/be/.env.example src/be/.env

# Start the stack
make up
```

## Usage

```shell
# Verify (build + test)
make verify

# Run tests
make test

# Start all services
make up

# Stop all services
make down

# Open a shell in the PHP container
make shell

# Run migrations
make migrate

# Seed database
make seed
```

## Testing

```shell
make test
```

See `docs/TESTING_STRATEGY.md` and `docs/TEST_REPORT.md` for details.

## Requirements

- PHP 8.5.12+
- Laravel 12.x
- MySQL 8.4+
- Docker & Docker Compose

## Documentation

- [Deployment](docs/DEPLOYMENT.md)
- [Operations](docs/OPERATIONS.md)
- [Security Review](docs/SECURITY_REVIEW.md)
- [Architecture](docs/ARCHITECTURE.md)
- [Repository Audit](docs/REPOSITORY_AUDIT.md)
- [Technical Debt](docs/TECHNICAL_DEBT.md)
- [Improvement Roadmap](docs/IMPROVEMENT_ROADMAP.md)

## Community

- [Code of Conduct](CODE_OF_CONDUCT.md)
- [Contributing](CONTRIBUTING.md)
- [Security Policy](SECURITY.md)
- [Support](SUPPORT.md)
- [Accessibility](ACCESSIBILITY.md)

## License

[MIT](LICENSE)
