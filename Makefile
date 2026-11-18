COMPOSE_PROJECT_NAME ?= magicport
COMPOSE_FILE ?= docker-compose.yml

.PHONY: build test verify up run down logs shell migrate seed security clean

build:
	docker compose build

test:
	docker compose build --target test
	docker compose run --rm phpunit

verify: build test

up: verify
	docker compose up -d

run:
	docker compose up -d

down:
	docker compose down -v

logs:
	docker compose logs -f

shell:
	docker compose run --rm php bash

migrate:
	docker compose run --rm artisan migrate

seed:
	docker compose run --rm artisan db:seed

security:
	docker compose run --rm composer audit 2>&1 || true

clean:
	@read -p "This will remove containers, volumes, and images. Continue? (y/N) " confirm && \
	[ "$$confirm" = "y" ] && docker compose down -v --rmi all || echo "Aborted."
