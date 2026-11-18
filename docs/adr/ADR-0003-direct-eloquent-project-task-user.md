# ADR-0003: Direct Eloquent for Project/Task/User controllers

## Status
Accepted

## Context
Project, Task, and User modules are straightforward CRUD over single Eloquent models with no complex business invariants. Introducing Repository/Service interfaces for each would add abstraction without benefit — no swapping need, no shared business logic, no testability gain beyond what Eloquent model binding already provides.

## Decision
Use direct Eloquent in controllers for Project, Task, and User:
- Controllers call `Project::create()`, `Task::findOrFail()`, `User::where('fin', ...)`, etc.
- Route model binding resolves `{project}`, `{task}`, `{user}` route parameters
- Validation via dedicated FormRequest classes (`StoreProjectRequest`, `UpdateProjectRequest`, etc.)
- No Repository/Service interfaces or implementations for these modules

## Consequences
- Less boilerplate, faster development
- Controllers are slightly thicker but still thin (validation + DB transaction + response)
- Consistent with KISS/YAGNI — remove speculative layers

## Justification
Per Phase 8 KISS/YAGNI principle: "remove speculative layers, unused abstractions". These modules are CRUD-style; DDD/Clean architecture doesn't earn its place here.

## Related
ADR-0001 (Company module uses Repository/Service — justified by domain complexity)
