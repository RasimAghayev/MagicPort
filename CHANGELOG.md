# Changelog

## [Unreleased]

### Added
- Health endpoints: `/health/live`, `/health/ready`
- Security headers middleware
- CORS configuration
- PHPStan configuration
- PHP-CS-Fixer configuration
- CI/CD pipeline (GitHub Actions)
- Dependabot configuration
- Community files (LICENSE, CODE_OF_CONDUCT, CONTRIBUTING, SECURITY, etc.)
- Tests: health endpoint tests, SecurityHeaders unit test

### Changed
- Upgraded `laravel/framework` from `^12.0` to `^13.0`
- Upgraded PHP requirement from `^8.2` to `^8.4`
- Upgraded `laravel/pint` from `^1.13` to `^1.32`
- Removed `secrets/` plaintext credential files from git history
- Renamed default branch from `develop` to `main`
- Added `preview` and `test` branches (3-branch model)

### Removed
- Dead code: `scripts/load-secrets.sh`

### Security
- Purged plaintext DB credentials from `secrets/` directory in git history
- Added security headers (X-Content-Type-Options, X-Frame-Options, etc.)
- Added gitleaks secret scanning to CI
- Added pre-commit secret scan hook

## [1.0.0] - 2026-11-18

### Added
- Initial Laravel skeleton release
- Docker Compose orchestration (nginx, php, mysql, composer, artisan, phpunit)
- Default Laravel authentication scaffold (User model, migrations)
- Vite frontend build configuration
