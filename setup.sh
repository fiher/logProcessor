#!/usr/bin/env bash
docker compose down --remove-orphans && \
docker compose build --no-cache && \
docker compose up --pull always -d --wait && \
docker-compose exec -t php bin/console doctrine:migrations:migrate -n
