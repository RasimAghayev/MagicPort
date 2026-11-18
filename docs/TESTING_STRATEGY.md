# Testing Strategy — MagicPort

## Test categories

| Category | Tools | Location | Purpose |
|---|---|---|---|
| Unit | PHPUnit | tests/Unit/ | Test individual classes in isolation |
| Feature | PHPUnit + Laravel Testing | tests/Feature/ | Test HTTP endpoints and user flows |

## Test conventions

- Test case IDs: `TC_<MODULE>_<SCENARIO>_<NUMBER>`
- Feature tests use `Tests\TestCase` (Laravel base)
- Unit tests extend `PHPUnit\Framework\TestCase`
- No mocks unless testing external service boundaries

## Existing tests (baseline)

| File | Type | Tests |
|---|---|---|
| tests/Feature/ExampleTest.php | Feature | 1 (welcome page 200) |
| tests/Unit/ExampleTest.php | Unit | 1 (assertTrue) |

## New tests (Phase 11)

| File | Type | Tests | Test IDs |
|---|---|---|---|
| tests/Feature/HealthTest.php | Feature | 3 | TC_HEALTH_LIVE_001, TC_HEALTH_READY_001, TC_WELCOME_001 |
| tests/Unit/SecurityHeadersTest.php | Unit | 1 | TC_SECURITY_HEADERS_001 |

## Execution

- Local: `docker compose run --rm phpunit` (requires Docker)
- CI: GitHub Actions `test` job (runs Docker test target)
- Coverage: Not configured yet (Phase 11 can add)
