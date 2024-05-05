#!/usr/bin/env bash
docker exec logprocessor-php-1 frankenphp php-server --worker public/franken_worker.php