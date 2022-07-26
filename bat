#!/usr/bin/env bash

function up {
  docker-compose up -d $@
}

function down {
  docker-compose down --remove-orphans
}

function restart {
  docker-compose down && docker-compose up -d
}

function test {
    echo "Test code..."
    if [ -z "${1}" ]; then
      docker-compose exec app bash -c 'vendor/bin/phpunit'
    else
      docker-compose exec app bash -c "vendor/bin/phpunit tests/${1}"
    fi
}

function init {
  echo "Copy backend .env..."
  docker-compose exec app php -r "copy('.env.example', '.env');"

  echo "Install backend dependencies..."
  docker-compose exec app composer install

  echo "Generate backend application key..."
  docker-compose exec app php artisan key:generate
}

function artisan() {
  docker-compose exec -w "/home/batch" app php artisan "${1}"
}

function composer() {
  docker-compose exec -w "/home/batch" app composer "${1}"
}

subcommand="$1"
shift

case $subcommand in
up)
  up $@
  ;;
down)
  down
  ;;
init)
  init
  ;;
restart)
  restart
  ;;
test)
  test ${1}
  ;;
artisan)
  artisan ${1}
  ;;
composer)
  composer ${1}
  ;;
*)
  echo "help"
  ;;
esac
