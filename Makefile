## Build the docker container, install the dependencies
build:
	@docker-compose build
	@make vendors-install

## Install the composer dependencies
vendors-install:
	@docker-compose run --rm --no-deps php composer install

## Copy dist files to actual path (if not present yet)
copy-dist-configs:
	@docker-compose run --rm --no-deps php cp -n .env.dist .env
	@docker-compose run --rm --no-deps php cp -n phpunit.xml.dist phpunit.xml
	@docker-compose run --rm --no-deps php cp -n phpstan.neon.dist phpstan.neon
	@docker-compose run --rm --no-deps php cp -n .php_cs.dist .php_cs

## Update composer autoload
dump-autoload:
	@docker-compose run --rm --no-deps php composer dump-autoload

## Run default game (2 players 3 moves)
run-server:
	@docker-compose run --rm --no-deps php php src/index.php

## Run all tests
all-tests:
	make unit-tests
	make functional-tests

## Run unit tests
unit-tests:
	@docker-compose run --rm --no-deps php ./vendor/bin/phpunit --no-coverage --stop-on-error --stop-on-failure --testsuite Unit

## Run functional tests
functional-tests:
	@docker-compose run --rm --no-deps php ./vendor/bin/phpunit --no-coverage --stop-on-error --stop-on-failure --testsuite Functional

## Run unit tests
static-analysis:
	@docker-compose run --rm --no-deps php ./vendor/bin/phpstan analyze

## Run unit tests
cs-fix:
	@docker-compose run --rm --no-deps php ./vendor/bin/php-cs-fixer fix