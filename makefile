# Makefile (must be TAB indented)

.PHONY : all .FORCE

all : build php test

build : composer

composer : .FORCE
	composer install

composer-autoload : .FORCE
	composer dump-autoload --optimize

node : .FORCE
	yarn install

php : standard-php phpmd lint-php phpstan

standard-php : .FORCE
	./vendor/bin/phpcs .

phpmd: .FORCE
	find src tests \
		-name \*.php -exec ./vendor/bin/phpmd {} text ruleset.xml \;

lint-php : .FORCE
	find src tests -name "*.php" -exec php -l {} > /dev/null \;

phpstan: .FORCE
	./vendor/bin/phpstan analyse --level 7 src tests *.php

test : .FORCE
	./vendor/bin/phpunit
