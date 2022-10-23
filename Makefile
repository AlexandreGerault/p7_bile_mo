#-----------------------------------------------------------
##@ # Install commands
#-----------------------------------------------------------
install:
	@echo "Installing..."
	@docker-compose up -d
	@docker-compose exec php composer install
	@docker-compose exec php bin/console doctrine:schema:update --force
	@docker-compose exec php bin/console doctrine:fixtures:load --no-interaction
	@docker-compose exec php bin/console cache:clear
	@echo "Installation done."


#-----------------------------------------------------------
##@ # Stack commands
#-----------------------------------------------------------

up: ## Start the project stack
	@docker-compose up -d
up-force: ## Start the project stack with recreate step
	@docker-compose up -d --force-recreate
up-build: ## Start the project stack with recreate & build steps
	@docker-compose up -d --build --force-recreate
down: ## Stop the project stack
	@docker-compose down
restart: down up ### Restart the project stack

status: ## Stack status
	@docker-compose ps

#-----------------------------------------------------------
##@ # Test commands
#-----------------------------------------------------------
up-test: ## Start the project stack
	@docker compose -f docker-compose.test.yaml --env-file=.env.test up -d

up-force-test: ## Start the project stack with recreate step
	@docker compose -f docker-compose.test.yaml --env-file=.env.test up -d --force-recreate
up-build-test: ## Start the project stack with recreate & build steps
	@docker compose -f docker-compose.test.yaml --env-file=.env.test up -d --build --force-recreate
down-test: ## Stop the project stack
	@docker compose -f docker-compose.test.yaml --env-file=.env.test down
restart-test: down up ### Restart the project stack

status-test: ## Stack status
	@docker compose -f docker-compose.test.yaml --env-file=.env.test ps

#-----------------------------------------------------------
##@ # Quality commands
#-----------------------------------------------------------

analyse: ## Static analysis
	@docker-compose run php ./vendor/bin/phpstan analyse --memory-limit=2G

prepare: analyse

#-----------------------------------------------------------
##@ # Nginx commands
#-----------------------------------------------------------

nginx: ## Opens a shell inside the Nginx container
	@docker-compose exec nginx bash
nginx-restart: ## Restart the Nginx service
	@docker-compose restart nginx
nginx-logs: ## Read Nginx service logs
	@docker-compose logs -f nginx

#-----------------------------------------------------------
##@ # PHP commands
#-----------------------------------------------------------

php: ## Opens a shell inside the PHP container
	@docker-compose exec php bash
php-restart: ## Restart the PHP service
	@docker-compose restart php
php-logs: ## Read PHP service logs
	@docker-compose logs -f php

composer: # Alias for "make php" Opens a shell inside the PHP container
	@docker-compose exec php bash
composer-install:
	@docker-compose exec php composer install
composer-dump:
	@docker-compose exec php composer dump-autoload

create-client:
	@docker-compose exec php php bin/console league:oauth2-server:create-client Client_Test

#-----------------------------------------------------------
##@ # Mysql commands
#-----------------------------------------------------------

mysql: ## Opens a shell inside the MySQL container
	@docker-compose exec mysql bash
mysql-restart: ## Restart the MySQL service
	@docker-compose restart mysql
mysql-logs: ## Read MySQL service logs
	@docker-compose logs -f mysql

#-----------------------------------------------------------
# Other commands
#-----------------------------------------------------------

.DEFAULT_GOAL := help
.PHONY: help
help: ## Display help
	@awk 'BEGIN {FS = ":.*##"; printf "Usage:\n  make <command> \033[36m\033[0m\n"} /^[a-zA-Z_-]+:.*?##/ { printf "  \033[36m%-15s\033[0m %s\n", $$1, $$2 } /^##@/ { printf "\n\033[1m%s\033[0m\n", substr($$0, 5) } ' $(MAKEFILE_LIST)
