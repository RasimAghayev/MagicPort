# Operations

## Health Endpoints

- `GET /health/live` — Liveness probe (returns `{"status":"live"}`)
- `GET /health/ready` — Readiness probe (returns `{"status":"ready"}`)

## Logging

Laravel logging is configured via `config/logging.php`. Logs are written to
`storage/logs/laravel.log` by default.

## Monitoring

No external monitoring is configured. Recommended:

- Uptime monitoring on `/health/live`
- Log aggregation (e.g., Loki, ELK)
- Error tracking (e.g., Sentry)

## Backup

MySQL data is stored in `./db/mysql/` on the host. Back up this directory
regularly.

## Scaling

The application is a single deployable unit. For horizontal scaling:

- Run multiple PHP-FPM instances behind a load balancer
- Use a shared database (MySQL)
- Use Redis for session/cache (currently commented out in docker-compose)
