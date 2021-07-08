current-dir := $(dir $(abspath $(lastword $(MAKEFILE_LIST))))

.PHONY: build
build: deps start

.PHONY: deps
deps: composer-install

# 🐘 Composer
composer-env-file:
	@if [ ! -f .env.local ]; then echo '' > .env.local; fi

.PHONY: composer-install
composer-install: CMD=install

.PHONY: composer-update
composer-update: CMD=update

.PHONY: composer-require
composer-require: CMD=require
composer-require: INTERACTIVE=-ti --interactive

.PHONY: composer-require-module
composer-require-module: CMD=require $(module)
composer-require-module: INTERACTIVE=-ti --interactive

.PHONY: composer
composer composer-install composer-update composer-require composer-require-module: composer-env-file
	@docker run --rm $(INTERACTIVE) --volume $(current-dir):/app --user $(id -u):$(id -g) \
		composer:2 $(CMD) \
			--ignore-platform-reqs \
			--no-ansi

.PHONY: reload
reload: composer-env-file
	@docker-compose exec php-fpm kill -USR2 1
	@docker-compose exec nginx nginx -s reload

.PHONY: test
test: composer-env-file
	docker exec docker_course_php_1 php /var/www/composer.phar check-style
	docker exec docker_course_php_1 php /var/www/composer.phar lint
	docker exec docker_course_php_1 php /var/www/composer.phar run-unit-tests
	docker exec docker_course_php_1 php /var/www/composer.phar run-acceptance-tests

.PHONY: static-analysis
static-analysis: composer-env-file
	docker exec docker_course_php_1 ./vendor/bin/psalm

.PHONY: run-tests
run-tests: composer-env-file
	mkdir -p build/test_results/phpunit
	./vendor/bin/simple-phpunit --exclude-group='disabled' --log-junit build/test_results/phpunit/junit.xml
	./vendor/bin/behat --format=progress -v

# 🐳 Docker Compose
.PHONY: start
start: CMD=-f ./docker/docker-compose.yml up --build -d

.PHONY: stop
stop: CMD=-f ./docker/docker-compose.yml stop

.PHONY: destroy
destroy: CMD=-f ./docker/docker-compose.yml down

# Usage: `make doco CMD="ps --services"`
# Usage: `make doco CMD="build --parallel --pull --force-rm --no-cache"`
.PHONY: doco
doco start stop destroy: composer-env-file
	@docker-compose $(CMD)

.PHONY: rebuild
rebuild: composer-env-file
	docker-compose build --pull --force-rm --no-cache
	make deps
	make start

clean-cache:
	@rm -rf apps/*/*/var
	@docker exec docker_course_php_1 ./bin/console cache:warmup

watch:
	@docker exec -it docker_course_node_1 npm run watch
