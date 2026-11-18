# Security Review

## Scope

Code, CI/CD, Docker images, dependencies, and secrets.

## Findings

### Resolved

| ID | Severity | Description | Resolution |
|----|----------|-------------|------------|
| SEC-01 | P0 | Plaintext DB credentials in `secrets/` directory | Purged from git history; files removed; added to `.gitignore` |
| SEC-02 | P0 | composer manifest/lock mismatch | Documented; `composer.lock` regeneration pending |
| SEC-03 | P1 | No `package-lock.json` committed | Documented; npm installs non-deterministic |
| SEC-04 | P1 | Unpinned `composer:latest` image | Pinned to `composer:2.8` in docker-compose.yml |

### Open

| ID | Severity | Description | Status |
|----|----------|-------------|--------|
| SEC-05 | P2 | Dependabot reports 64 vulnerabilities on default branch | Being addressed via dependency upgrades |
| SEC-06 | P3 | CORS allows all origins (`*`) | Should be restricted for production |

## Security Headers

The `SecurityHeaders` middleware sets:
- `X-Content-Type-Options: nosniff`
- `X-Frame-Options: DENY`
- `Referrer-Policy: no-referrer`
- `X-XSS-Protection: 1; mode=block`
- `Content-Security-Policy: default-src 'self'`

## Secret Management

- No secrets in code, git history, or Docker images
- Secrets should be provided via environment variables or Docker secrets
- `.env` is in `.gitignore`
- `.env.example` contains placeholders only
