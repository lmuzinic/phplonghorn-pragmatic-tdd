.DEFAULT_GOAL := build

USER:=$(shell id -u)
GROUP:=$(shell id -g)

build:
	@docker-compose build
	@docker-compose run --rm --user=$(USER):$(GROUP) php-cli composer -vv install

test:
	@docker-compose run --rm php-cli vendor/bin/phpunit

coverage:
	@docker-compose run --rm php-cli php -d zend_extension=/usr/local/lib/php/extensions/no-debug-non-zts-20180731/xdebug.so vendor/bin/phpunit --coverage-html var/coverage

bash:
	@docker-compose run --rm php-cli bash
