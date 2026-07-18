.PHONY: up down migrate console

up:
	docker compose build
	docker compose up -d

down:
	docker compose down

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
