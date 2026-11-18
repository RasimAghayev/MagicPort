# Deployment

## Docker Compose (Local Development)

```shell
# Build and start all services
make up

# Or manually:
docker compose up -d --build

# Access the application
# http://localhost (nginx)
```

## Production Deployment

1. Push a tag to `main`: `git tag v1.0.0 && git push origin v1.0.0`
2. GitHub Actions builds and publishes the Docker image to GHCR
3. Pull the image on the production server
4. Run `docker compose up -d` with production environment variables

## Environment Variables

See `.env.example` for all required environment variables. Copy to `.env` and
fill in production values.

```shell
cp src/be/.env.example src/be/.env
# Edit .env with production values
```

## Database

MySQL 26.7.0 is used as the database. Migrations are run via:

```shell
make migrate
```
