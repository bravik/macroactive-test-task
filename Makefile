init:
	sudo docker-compose up -d
	docker-compose exec macroactive_backend bin/console doctrine:database:create
	sudo chmod 777 var/sqlite.db
	docker-compose exec macroactive_backend bin/console do:mi:mi --no-interaction

up:
	sudo docker-compose up -d

test:
	sudo docker-compose -f docker-compose.yml -f docker-compose.test.yml up -d
	-docker-compose exec macroactive_backend bin/phpunit
	docker-compose down

down:
	docker-compose down
