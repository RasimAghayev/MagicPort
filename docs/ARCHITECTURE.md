# Architecture — MagicPort

## Overview

MagicPort is a vanilla Laravel skeleton application. It provides a baseline Laravel installation with Docker Compose orchestration, awaiting business-domain implementation.

## Directory structure

```
MagicPort/
├── docker-compose.yml          # Multi-service orchestration (nginx, php, mysql, composer, artisan, phpunit)
├── php.dockerfile              # PHP 8.5-FPM base image with Laravel extensions
├── nginx.dockerfile            # nginx stable-alpine with default site config
├── server/nginx/               # nginx site configuration
├── scripts/load-secrets.sh     # Secret-loading entrypoint stub (not wired)
├── secrets/                    # Plaintext DB credentials (7 files) — COMPROMISED, see Phase 9
├── src/be/                     # Laravel backend application
│   ├── app/
│   │   ├── Http/Controllers/Controller.php
│   │   ├── Models/User.php
│   │   └── Providers/AppServiceProvider.php
│   ├── bootstrap/
│   ├── config/                 # Laravel config files (app, auth, database, etc.)
│   ├── database/
│   │   ├── factories/UserFactory.php
│   │   ├── migrations/         # 3 default Laravel migrations
│   │   └── seeders/DatabaseSeeder.php
│   ├── public/
│   ├── resources/
│   │   ├── css/, js/, views/   # Vite-managed assets + welcome blade view
│   ├── routes/
│   │   ├── web.php             # Single GET / route → welcome view
│   │   └── console.php         # Default inspire Artisan command
│   ├── tests/
│   │   ├── Feature/ExampleTest.php
│   │   └── Unit/ExampleTest.php
│   ├── composer.json / composer.lock   # PHP dependencies (manifest/lock MISMATCH — see Phase 2)
│   ├── package.json            # npm dev deps (no lockfile committed)
│   ├── vite.config.js
│   └── phpunit.xml
└── src/fe/                     # Empty — frontend placeholder, no implementation
```

## Architecture pattern

Laravel monolithic MVC:
- **Requests** enter via `routes/web.php` → controller → model → view
- **Database** via Eloquent ORM (default `User` model only)
- **Configuration** via `config/*.php` + `.env` (not committed; `.env.example` exists)
- **Assets** compiled by Vite (dev) / `vite build` (prod)

## Boundaries

No module boundaries, no bounded contexts, no hexagonal adapters. Single deployable unit (Laravel app + MySQL + nginx). Not yet a modular monolith — no real domain complexity to justify it.

## External dependencies

- MySQL 26.7.0 (database)
- Packagist (Composer packages)
- npm registry (frontend dev tools)

## Diagrams

None yet — no real flows to diagram. Will be added in Phase 15 once business logic exists.

## Standards applied

- PSR-4 autoloading (`App\` → `app/`, `Database\*` → `database/`, `Tests\` → `tests/`)
- Laravel conventions (directory layout, config naming, migration naming)
