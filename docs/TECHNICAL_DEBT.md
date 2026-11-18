# Technical Debt — MagicPort

## TD-1: Plaintext secrets in `secrets/` (P0)

7 plaintext credential files committed to git. Must be removed from history (Gate 1), credentials rotated, and secret management moved to env/Docker secrets.

## TD-2: composer manifest/lock mismatch (P0)

`laravel/framework ^12.0` declared but `v11.21.0` locked. Lock must be regenerated or manifest corrected before any `composer install`.

## TD-3: No `package-lock.json` (P1)

npm install non-deterministic. Commit lockfile or remove frontend deps if unused.

## TD-4: Unpinned `composer:latest` image (P1)

Pin to digest for reproducible builds.

## TD-5: Missing community/operational files (P2)

CODE_OF_CONDUCT, CONTRIBUTING, SECURITY, ACCESSIBILITY, SUPPORT, CHANGELOG, CODEOWNERS, templates, Dependabot, CI workflow all missing (Phase 10/15).

## TD-6: Default branch `develop` (P2)

Rename to `main`, create `preview`/`test`, configure 3-branch model (Phase 4, Gate 4).

## TD-7: Empty frontend `src/fe/` (P3)

No frontend implementation despite reserved paths and commented compose services.

## TD-8: PHP version drift (P3)

Dockerfile `php:8.5-fpm` vs composer `^8.2`. Align during Phase 6.

## Minimal custom code

Skeleton only — no custom business code to refactor. Debt is almost entirely infrastructure/ops.
