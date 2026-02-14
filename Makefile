.PHONY: up down enter install test lint

up:
	docker-compose up -d

down:
	docker-compose down

enter:
	docker-compose exec app bash

install:
	docker-compose exec app composer install

test:
	docker-compose exec app vendor/bin/phpunit -c dev/tests/unit/phpunit.xml.dist

lint:
	docker-compose exec app vendor/bin/phpcs --standard=Magento2 app/code/Agency
	docker-compose exec app vendor/bin/phpstan analyse app/code/Agency
