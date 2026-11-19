# Best Practices — MagicPort

This document defines coding, security, API, database, testing, and CI/CD standards for the MagicPort backend. All new modules and changes must follow these practices.

## 1. Layered Architecture

Every module follows the strict **Controller → Service → Repository → Model** flow:

| Layer | Responsibility | Example |
|-------|--------------|---------|
| Routes | Route definitions, middleware, versioning | `routes/api.php` |
| Controller | HTTP input/output, delegation to Service, response formatting | `App\Http\Controllers\V1\{Module}\{Module}Controller.php` |
| Service | Business logic, transactions, validation orchestration | `App\Services\V1\{Module}\{Module}Service.php` |
| Repository | Eloquent data access, queries, soft-delete/restore | `App\Repositories\V1\{Module}\{Module}Repository.php` |
| Model | Eloquent model, casts, relationships | `App\Models\V1\{Module}.php` |

Rules:
- Controllers **must not** contain business logic or Eloquent queries beyond relationship eager-loading.
- Services **must not** access `$request` directly; they receive plain arrays.
- Repositories **must not** contain business logic; only data access.
- Every module must have both an Interface and an Implementation for Service and Repository.
- Bindings go in `RepositoryServiceProvider::register()`.

## 2. Naming Conventions

| Element | Convention | Example |
|---------|-----------|---------|
| Model | `App\Models\V1\{Module}` (PascalCase, singular) | `App\Models\V1\Invoice` |
| Repository Interface | `App\Repositories\V1\{Module}\{Module}RepositoryInterface` | `InvoiceRepositoryInterface` |
| Repository Impl | `App\Repositories\V1\{Module}\{Module}Repository` | `InvoiceRepository` |
| Service Interface | `App\Services\V1\{Module}\{Module}ServiceInterface` | `InvoiceServiceInterface` |
| Service Impl | `App\Services\V1\{Module}\{Module}Service` | `InvoiceService` |
| Controller | `App\Http\Controllers\V1\{Module}\{Module}Controller` | `InvoiceController` |
| Store Request | `App\Http\Requests\V1\{Module}\Store{Module}Request` | `StoreInvoiceRequest` |
| Update Request | `App\Http\Requests\V1\{Module}\Update{Module}Request` | `UpdateInvoiceRequest` |
| Resource | `App\Http\Resources\V1\{Module}\{Module}Resource` | `InvoiceResource` |
| Collection | `App\Http\Resources\V1\{Module}\{Module}Collection` | `InvoiceCollection` |
| Factory | `Database\Factories\V1\{Module}Factory` | `InvoiceFactory` |
| Migration | `YYYY_MM_DD_HHHHHH_create_{module}s_table.php` | `2025_01_01_000011_create_invoices_table.php` |

Route URLs use plural kebab-case: `/api/v1/invoices`, `/api/v1/contracts`, `/api/v1/tickets`.

## 3. Primary Keys & Soft Deletes

- Domain models (Company, Project, Task, Invoice, Contract, Ticket) use **string primary keys** named `code`.
- `User` uses integer primary key `id`.
- Every domain table uses **soft deletes** (`SoftDeletes` trait + `deleted_at` column).
- Every module supports: index, store, show, update, destroy (soft delete), restore, force-delete.
- `public $incrementing = false;`, `protected $keyType = 'string';`, `protected $primaryKey = 'code';`.

## 4. API Response Standard

All responses go through `ApiResponseClass`:

- Success: `{ success: true, message: string, data: mixed }` (200)
- Created: `{ success: true, message: string, data: mixed }` (201)
- Deleted: `{ success: true, message: string, data: null }` (204)
- Error: `{ success: false, message: string, errors?: array }` (400/404/422)

Controller helpers: `respond()`, `respondCreated()`, `respondDeleted()`, `respondError()`, `respondValidationError()`.

## 5. Request Validation

- Every write operation (store, update) uses a dedicated **FormRequest** class.
- `authorize()` returns `true` (auth handled by Sanctum middleware at route level).
- `rules()` defines validation; `messages()` defines custom user-facing messages.
- Update requests use the route key for unique rule exclusion: `unique:table,column,$this->route('key'),key_column`.

## 6. API Resources

- Every model has a **Resource** (`JsonResource`) and a **Collection** (`JsonResource` with `data` + `meta`).
- Collection meta includes: `current_page`, `per_page`, `total`, `last_page`.
- Resources expose only safe, cast fields; never expose `password`, `remember_token`, or internal IDs unless intentional.
- Dates use `->toISOString()`; decimals cast to `(float)`.

## 7. Filters & Pagination

- `index()` accepts optional filters via `$request->only([...])`.
- Default `perPage = 15`, overridable via `?perPage=` query param.
- Filters supported: `status`, `search`, plus module-specific filters (e.g. `company_code`, `priority`, `user_id`).
- Results ordered by `created_at desc`.

## 8. Security

- **PHP2Shell hardening**: `disable_functions` in `php.ini` blocks `shell_exec,exec,passthru,system,proc_open,popen,pcntl_exec,proc_get_status,proc_close,proc_terminate,escapeshellcmd,escapeshellarg`.
- `composer install` in Docker test stage uses `--no-scripts` because `proc_open` is disabled (needed by `package:discover`).
- `expose_php = Off` in `php.ini`.
- All API routes (except auth login/register) protected by `auth:sanctum` middleware.
- SQL injection prevention: Eloquent query builder + parameter binding; never raw string concatenation in queries.
- Mass assignment protection: `$fillable` on all models; never `$guarded = []`.
- Password hashing via Laravel's `Hash` facade (bcrypt/argon2id).
- CORS and CSRF configured for stateless API (Sanctum tokens).

## 9. Database Standards

- All migrations use `Schema::create()` / `Schema::dropIfExists()`.
- Foreign keys use `foreignId()->constrained('table', 'column')->nullOnDelete()`.
- Indexes on: foreign keys, `status`, `search`-able fields (e.g. `invoice_number`, `ticket_number`, `contract_number`), `code` (auto via primary key).
- Enums for status/priority fields with explicit allowed values.
- Soft deletes on all domain tables via `$table->softDeletes()`.
- Timestamps on all tables via `$table->timestamps()`.

## 10. Testing Standards

- Feature tests for every module endpoint (index, store, show, update, destroy, restore, force-delete).
- Use `RefreshDatabase` trait for database isolation.
- Tests use factories for test data creation.
- Assert response status codes and JSON structure (`success`, `message`, `data`).
- Unit tests for Service and Repository classes where business logic exists.
- Run tests via CI pipeline; locally via `php artisan test` or `vendor/bin/phpunit`.

## 11. Docker / CI Standards

- `php.dockerfile` uses multi-stage build: `base` → `runtime` / `test`.
- Test stage copies `.env.example` → `.env` **before** `composer install`.
- Test stage uses `composer install --no-scripts` (PHP2Shell `proc_open` disabled).
- `composer.lock` is **not** committed; generated fresh from `composer.json` at build time.
- CI runs on `push` to `main` only; PRs to `preview` trigger lint + tests.
- CI jobs: Lint & Format, Secret Scan, Tests, Dependency Audit, Build Image.
- All 5 CI jobs must pass before merge to `main`.

## 12. Git & Commit Standards

- Conventional Commits: `feat:`, `fix:`, `refactor:`, `ci:`, `docs:`, `chore:`.
- Commit on `preview`, then `push origin preview:main` to trigger main CI.
- Pre-commit hook blocks `.env.example` placeholder env var names; use `--no-verify` when needed.
- Never commit secrets, keys, or `.env` files with real values.

## 13. Adding a New Module (Checklist)

1. Create migration: `database/migrations/YYYY_MM_DD_HHHHHH_create_{module}s_table.php`
2. Create model: `app/Models/V1/{Module}.php` (string PK `code`, soft deletes, `$fillable`, `$casts`, relationships)
3. Create Repository Interface + Implementation: `app/Repositories/V1/{Module}/`
4. Create Service Interface + Implementation: `app/Services/V1/{Module}/`
5. Create Controller: `app/Http/Controllers/V1/{Module}/{Module}Controller.php`
6. Create Store + Update FormRequests: `app/Http/Requests/V1/{Module}/`
7. Create Resource + Collection: `app/Http/Resources/V1/{Module}/`
8. Create Factory: `database/factories/V1/{Module}Factory.php`
9. Register routes in `routes/api.php` (apiResource + restore + force-delete)
10. Add DI bindings in `RepositoryServiceProvider::register()`
11. Add Resource import in `RepositoryServiceProvider.php` if referenced
12. Update `ARCHITECTURE.md` directory structure and module table
13. Write Feature tests for all endpoints
14. Commit on `preview`, push to `main`, verify CI green

## 14. Current Modules

| Module | Primary Key | Table | Status |
|--------|------------|-------|--------|
| Company | `code` (string) | `companies` | ✅ |
| Project | `code` (string) | `projects` | ✅ |
| Task | `code` (string) | `tasks` | ✅ |
| User | `id` (int) | `users` | ✅ |
| Invoice | `code` (string) | `invoices` | ✅ |
| Contract | `code` (string) | `contracts` | ✅ |
| Ticket | `code` (string) | `tickets` | ✅ |
| Auth | n/a | Sanctum tokens | ✅ |
| AuditLog | morphs | `audit_logs` | ✅ |
