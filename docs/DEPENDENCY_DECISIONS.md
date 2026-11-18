# Dependency Decisions

## Laravel Framework

- **Decision**: Upgrade from v11.21.0 to v13.x (latest stable)
- **Reason**: Standing decision 1 — latest versions always
- **Existing coverage**: None — this is the framework itself
- **Maintenance**: Actively maintained by Laravel team
- **License**: MIT
- **Known vulnerabilities**: See GitHub Dependabot alerts (64 advisories at time of upgrade)
- **Size**: Full framework (~30 MB installed)
- **Latest stable**: v13.43.0
- **Breaking changes**: Major version jump from v11 to v13; migration notes required
- **Status**: Pending `composer.lock` regeneration (composer not available on host)

## PHP Runtime

- **Decision**: Require PHP ^8.4
- **Reason**: Laravel 13 compatibility; latest stable PHP 8.x
- **Existing coverage**: None
- **Maintenance**: Actively maintained by PHP team
- **License**: PHP License
- **Latest stable**: PHP 8.5
- **Status**: composer.json updated; lockfile pending regeneration

## Laravel Pint

- **Decision**: Upgrade from ^1.13 to ^1.32
- **Reason**: Latest stable; code formatter
- **Existing coverage**: None
- **Maintenance**: Actively maintained by Laravel team
- **License**: MIT
- **Latest stable**: v1.32.3
- **Status**: composer.json updated; lockfile pending regeneration

## Dependabot

- **Decision**: Configure weekly updates (Monday 06:00 UTC)
- **Reason**: Standing decision 14 — keep dependencies at latest
- **Ecosystems**: Composer, npm, Docker, GitHub Actions
- **Target branch**: preview
- **Status**: Configured in `.github/dependabot.yml`
