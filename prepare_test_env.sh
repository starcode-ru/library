#!/usr/bin/env sh
php ./app/console --env=test doctrine:database:drop --force
php ./app/console --env=test doctrine:database:create
php ./app/console --env=test doctrine:migrations:migrate --no-interaction
php ./app/console --env=test cache:clear
