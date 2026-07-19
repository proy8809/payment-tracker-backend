.PHONY: up down migrate console

NETWORK := payment-tracking-net

up:
	@if ! docker network inspect $(NETWORK) >/dev/null 2>&1; then \
		docker network create --driver bridge $(NETWORK); \
	fi
	docker compose -p payment-tracking up -d --force-recreate --build

down:
	docker compose -p payment-tracking down -t 0

migrate:
	@if docker compose exec php sh -c '[ -d migrations ] && ls -A migrations/*.php 2>/dev/null' > /dev/null 2>&1; then \
		docker compose exec php bin/console doctrine:migrations:migrate --no-interaction; \
	else \
		echo "No pending migrations."; \
	fi

console:
	docker compose exec php bin/console $(filter-out $@,$(MAKECMDGOALS))

%:
	@true
