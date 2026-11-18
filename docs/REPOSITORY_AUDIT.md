# Repository Audit — MagicPort

## Scope

Full-discovery audit of the MagicPort repository as received on `develop` (HEAD `342854c`).

## Structure

Standard Laravel skeleton. No custom business logic. `src/fe/` is empty. `secrets/` contains plaintext credentials.

## Stack

- PHP ^8.2 / Laravel ^12.0 (declared) / v11.21.0 (locked)
- MySQL 26.7.0, nginx stable-alpine, composer:latest (unpinned)
- Vite ^5.0, axios ^1.6.4, laravel-vite-plugin ^3.0.0 (npm, no lockfile)

## Findings

### P0 — Plaintext secrets committed
`secrets/` (7 files: db_connection, db_database, db_host, db_password, db_port, db_root_password, db_username) are committed plaintext. Compromised per CLAUDE.md Security §9.

### P0 — composer manifest/lock mismatch
`composer.json` requires `laravel/framework ^12.0`; `composer.lock` pins `v11.21.0`. `composer install` will fail.

### P1 — No package-lock.json
npm dependencies not locked; non-deterministic installs.

### P1 — Unpinned `composer:latest` image
Non-reproducible builds.

### P2 — Missing community files
No CODE_OF_CONDUCT, CONTRIBUTING, SECURITY, ACCESSIBILITY, SUPPORT, CHANGELOG, CODEOWNERS, issue/PR templates, Dependabot, CI workflow.

### P2 — Default branch `develop`
Not `main`; no `preview`/`test` branches (3-branch model not configured).

### P3 — Empty frontend
`src/fe/` empty; commented-out npm services in compose.

### P3 — PHP version drift
Dockerfile `php:8.5-fpm` vs composer `^8.2`.

## Existing tests

2 default Laravel tests (feature + unit), smoke-level only.

## CI/CD

None.

## Cross-repo links

None.

## Recommendation

Resolve P0/P0/P1/P1 in Phases 4–6. Build out business functionality only after skeleton is stable.
