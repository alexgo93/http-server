install:
	composer install
lint:
	composer run-script phpcs -- --standard=PSR1,PSR2 bin src
fix-lint:
	phpcbf --standard=PSR1,PSR2 bin src
update:
	composer update