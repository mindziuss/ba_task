setup:
	@make build
	@make up 
	@make composer-update
	@make storage-chmod
build:
	docker-compose build --no-cache --force-rm
stop:
	docker-compose stop
up:
	docker-compose up -d
composer-update:
	docker exec laravel-docker bash -c "composer update"
data:
	docker exec laravel-docker bash -c "php artisan migrate"
	docker exec laravel-docker bash -c "php artisan db:seed"
storage-chmod:
	$(shell ./storage-chmod.sh)
default-user:
	docker exec laravel-docker bash -c "php artisan make:filament-user --name="admin" --email="admin@example.com" --password="admin""
	docker exec laravel-docker bash -c "echo -e '\e[32mLogin:\e[0m admin@example.com \e[32mPassword:\e[0m admin'"