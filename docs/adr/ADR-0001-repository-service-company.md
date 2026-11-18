# ADR-0001: Repository/Service pattern for Company module

## Status
Accepted

## Context
The Company module needed a clean separation between HTTP layer, business logic, and data access. The merged `be-task` code introduced Company domain entities (Company, Project, Task, User) with CRUD operations. Without a repository/service abstraction, controllers would directly call Eloquent, mixing concerns and making testing harder.

## Decision
Apply the Repository + Service pattern to the Company module:
- `CompanyRepositoryInterface` / `CompanyRepository` — data access via Eloquent `Company` model
- `CompanyServiceInterface` / `CompanyService` — business logic orchestration
- `CompanyController` — HTTP layer, delegates to service
- `CompanyDTO` — data transfer between HTTP and service layers

## Consequences
- Clear separation of concerns; controllers are thin
- Business logic is testable without HTTP
- Repository can be swapped if data source changes
- More boilerplate than direct Eloquent calls

## Justification
Company is a core domain entity with relationships to Users, Projects, Tasks. The abstraction earns its place per Phase 8 Clean/Hexagonal principle (external systems need swapping).

## Related
ADR-0003 (direct Eloquent for Project/Task/User — KISS/YAGNI wins for simpler modules)
