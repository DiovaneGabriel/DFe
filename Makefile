.PHONY: test

CONTAINER_PHP = dfe-php-test

test:
	clear && \
	docker exec ${CONTAINER_PHP} php ./test/test.php

install:
	clear && \
	docker exec -it ${CONTAINER_PHP} sh -c "cd /var/www/html && composer update --dev"

composer-update:
	docker exec -it ${CONTAINER_PHP} sh -c "cd /var/www/html && composer update"

bash:
	clear && \
	docker exec -it ${CONTAINER_PHP} /bin/bash

up:
	docker compose up -d

down:
	docker compose down