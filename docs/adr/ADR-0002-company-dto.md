# ADR-0002: DTO pattern for company data transfer

## Status
Accepted

## Context
Company creation/update requests pass data from HTTP requests to the service layer. Passing raw request arrays couples the service to the HTTP layer and loses type safety. A DTO provides a typed, immutable contract.

## Decision
Introduce `CompanyDTO` (readonly class with `userId: int`, `name: string`, `status: string`) as the data contract between `CompanyController` and `CompanyService`. The controller validates via `StoreCompanyRequest`/`UpdateCompanyRequest`, maps to `CompanyDTO`, and passes it to the service.

## Consequences
- Type-safe data transfer between layers
- Immutable data (readonly class)
- Service is independent of HTTP request objects
- Extra class to maintain for simple CRUD

## Justification
The Company domain has validation rules and relationships; a DTO makes the service contract explicit and testable.

## Related
ADR-0001 (Repository/Service pattern uses CompanyDTO)
