# Docker guild line
# make cache : Laravel clear config, cache, router cache
# make: build npm, client
# make build : build npm, client
# make remake : clear all container and re install
# make down : close container docker
# make up : startt all container docker
# make gitup : commit all curentt update and push on git
all: build down up cache
up:
	docker compose up -d
cache:
	/usr/local/php81/bin/php artisan route:cache
	/usr/local/php81/bin/php artisan config:clear
	sudo chmod -R 777 storage
	/usr/local/php81/bin/php artisan cache:clear
gitup:
	git add .
	git commit -m "push all"
	git push
setup:
	sh bin/docker_setup.sh
build:
	docker compose build
init:
	docker compose up -d --build
remake:
	@make destroy
	@make init
stop:
	docker compose stop
# close all container docker
down:
	docker compose down --remove-orphans
down-v:
	docker compose down --remove-orphans --volumes
restart:
	@make down
	@make up
destroy:
	docker compose down --rmi all --volumes --remove-orphans
ps:
	docker compose ps
logs:
	docker compose logs
logs-watch:
	docker compose logs --follow
