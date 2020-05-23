## Build the docker container, install the dependencies
build:
	@docker-compose build
	@make vendors-install

## Install the composer dependencies
vendors-install:
	@docker-compose run --rm --no-deps php composer install

## Update composer autoload
dump-autoload:
	@docker-compose run --rm --no-deps php composer dump-autoload

## Run server
run-server:
	@docker-compose up -d

## Migrate
migrate:
	@docker-compose run php bin/console doctrine:migrations:migrate

## Import listing
import-listing:
	@docker-compose run php bin/console app:listing:import

## Run messenger workers with log
run-messenger-workers-with-log:
	@docker-compose run php bin/console messenger:consume -vv async

docker-compose run php bin/console messenger:consume -vv async
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