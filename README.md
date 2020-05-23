# Assignment quotes retriever

Test assignment implementation for php api that retrieves quotes from third party api,
displays them in the table and chart and sends user notification on email.

## Key implementation notes

**Basic idea of this implementation is asynchronous architecture,
so that slow and failure-risky third party services for quotes and email
do not slow down the user interface**

The user flow is of following steps:

1) User submits form (i.e. `POST` api request) - so the `historical_quotes_task` item is created and its UUID is returned
 - No heavy synchronous for third party services as Quotes and Email are executed,
  but tasks for them added to Queue for asynchronous processing by background workers.
2) User is immediately redirected to Task page, where frontend periodically checks status (`GET` request for statuses)
 of async background tasks.
3) Async background tasks do their job and fill in fields of `historical_quotes_task` entry,
 so frontend receives ready statuses for both tasks
4) As in (3) quotes data was stored on `historical_quotes_task` entry,
 frontend just gets them (`GET` request for quotes retrieval) and displays table and chart.
 
## Technical implementation notes

1) Project has both `Monolith` (Symfony forms) controller and a standalone `Api` controller.

2) Project uses `Command Bus` pattern, and relies on `Tactitian` bundle implementation for this pattern.

3) Symfony validation may be applied in the same way to both `Commands`, `Forms` and `Entities`,
 with the exception that Symfony forms may have validators like `EntityType`, 
 that possibly might be useful for symbol validation.

3.1) So on the `Api` controller while forms are not used, it's still matching validation requirements for the BE,
 while `Monolith` controller uses both Symfony forms validation and bindings, after which Command is handled.

4) For asynchronous processing of Quotes retrieving and Email task, Symfony Messenger is used https://symfony.com/doc/current/components/messenger.html
It's configured for doctrine transport bus, for the sake of simplicity, however it could be easily changed to more production ready implementation as `Amqp` 
 
## TODOs (have not implemented before the deadline because of lack if time)
 - Unit / Functional tests
 - Quotes pagination

## Project setup on the development machine

#### Prerequisites
1) Install Docker and optionally Make utility.
 
2) Commands from Makefile could be executed manually in case Make utility is not installed.

3) Email delivery is configured via https://www.mailgun.com service, so to check email delivery you need to:
     - Register at https://www.mailgun.com
     - Pass the required checks ( email verification and etc)
     - On the free sandbox version it allows only whitelisted email for delivery, so you need to add and validate your email to whitelist
     - Retrieve MAILGUN_USERNAME and MAILGUN_PASSWORD to use it in the project config

#### Build container and install composer dependencies

    make build

#### Build container and install composer dependencies

If dist files are not copied to actual destination, then
    
    cp -n .env.dist .env
    cp -n phpunit.xml.dist phpunit.xml
    cp -n phpstan.neon.dist phpstan.neon
    cp -n .php_cs.dist .php_cs
        
#### Manually add tokens for Mailgun email service and Rapidapi exchange quotes service

    On .env in MAILER_DSN replace MAILGUN_USERNAME and MAILGUN_PASSWORD to youe credentials
    
    On .env in QUOTES_SERVICE_HEADER_X_RAPIDAPI_KEY set value to your key
    
#### Run docker containers

    make run-server

#### Import listing (symbols to company names table)

    make migrate

#### Import listing (symbols to company names table)

    make import-listing

#### Run symfony messenger workers for background processing (preferably with logs), and keep console window opened

    make run-messenger-workers-with-log
    
## Useful development tools

#### Code style fixer 

    make cs-fix
    
#### Static analysis 

    make static-analysis
    
#### Run all tests

Runs container and executes all tests.

    make all-tests
    
#### Run unit tests

Runs container and executes unit tests.

    make unit-tests

#### Run functional tests

Runs container and executes functional tests.

    make functional-tests