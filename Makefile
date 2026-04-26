PORT ?= 8001
build-dev-image:
	docker build --target dev --tag hexlet-php-project-57:dev .

build-prod-image:
	docker build --target prod --tag hexlet-php-project-57:prod .

run:
	php artisan serve --host=0.0.0.0 --port=$(PORT)

log:
	tail -f storage/logs/laravel.log

run-dev:
	docker run --rm -itd -p $(PORT):8000 -p 5173:5173 -v $(CURDIR):/app --name hexlet-php-project-57-dev hexlet-php-project-57:dev composer run-script dev
	make bash-dev

bash-dev:
	docker exec -it hexlet-php-project-57-dev bash

run-prod:
	docker run --rm -itd -p $(PORT):8000 --env-file ./.env.production --name hexlet-php-project-57-prod hexlet-php-project-57:prod

bash-prod:
	docker exec -it hexlet-php-project-57-prod bash

stop-dev:
	docker stop hexlet-php-project-57-dev

stop-prod:
	docker stop hexlet-php-project-57-prod

phpstan:
	php vendor/bin/phpstan analyse --memory-limit=1G --debug -vvv

phpcs:
	php vendor/bin/phpcs

lint: phpcs phpstan

lint-fix:
	php vendor/bin/phpcbf
