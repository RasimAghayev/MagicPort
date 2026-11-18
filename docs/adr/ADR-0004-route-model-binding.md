# ADR-0004: Route model binding for User/Task/Project controllers

## Status
Accepted

## Context
Project, Task, and User controllers need to look up a single record by ID (or `fin` for users) before showing/updating/deleting. Manual `findOrFail()` calls duplicate 404 handling and mix lookup logic with business logic.

## Decision
Use Laravel implicit route model binding:
- `{project}` → `Project::findOrFail($id)` automatically
- `{task}` → `Task::findOrFail($id)` automatically
- `{user}` → `User::findOrFail($id)` automatically
- Controllers receive the resolved model instance directly

## Consequences
- 404 handling delegated to framework (consistent with rest of app)
- Less boilerplate in controllers
- Binding works with soft-deleted models (findOrFail respects `deleted_at`)

## Justification
Laravel convention; reduces duplication; aligns with how CompanyResource and other parts of the codebase already use model binding.
