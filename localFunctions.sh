#!/bin/bash

source ./colors.sh;
export DOCKER_PATH=/docker
export SERVER_COMPOSE_FILE_PATH=./docker/docker-compose.yml
#SERVER_COMPOSE_FILE_PATH=./docker/docker-compose.test.yml

if [ -f ./docker/.env ]; then
    set -a
    source ./docker/.env
    set +a
fi

ENV_DIRS=(/ /nginx /php-fpm /php-cli /mysql /mailhog /minio)

# https://docs.docker.com/compose/environment-variables/envvars/#compose_env_files
export COMPOSE_PROJECT_NAME=delivery-backend
# export COMPOSE_FILE=./docker/docker-compose.yml
# export COMPOSE_FILE=$COMPOSE_FILE
# export COMPOSE_ENV_FILES=$COMPOSE_ENV_FILES

function makeCopyFromEnvFile()
{
    COPY_FROM_ENV=".env"

    if [[ -n "$1" ]]; then
        COPY_FROM_ENV+=".$1"
    else
        COPY_FROM_ENV+=".example"
    fi
}

# Create .env from .env.example
function env()
{
    makeCopyFromEnvFile "$1"

    # if [ ! -f .env ]; then
        cp ./$COPY_FROM_ENV ./.env
    # fi
}

function dockerEnv()
{
    makeCopyFromEnvFile "$1"

    for dir in ${ENV_DIRS[@]} ; do
        cp ./$DOCKER_PATH/$dir/$COPY_FROM_ENV ./$DOCKER_PATH/$dir/.env
    done

    # if [ ! -f ./docker/.env ]; then
    #     cp ./docker/$COPY_FROM_ENV ./docker/.env
    # fi
}

function status()
{
    docker compose ps
}

function start()
{
    docker compose up -d --force-recreate --remove-orphans
    status
}

function start-production-dependents()
{
    export COMPOSE_PATH_SEPARATOR=:
    export COMPOSE_FILE=./docker/docker-compose.production.yml:./docker/docker-compose.production.dependencies.yml
    docker compose up -d --force-recreate --remove-orphans
    status
}

function stop()
{
    docker compose down --remove-orphans
}

function restart()
{
    stop
    start
}

function pull()
{
    docker compose pull --no-parallel
}

function build()
{
	docker compose build "${@:1}"
}

function migrations()
{
    ARGS="${@:1}";

    if [[ "${@:1}" == *"execute --down"* ]]; then
        ARGS="execute --down 'Project\\Domains\\Admin\\Authentication\\Infrastructure\\Repositories\\Authentication\\Doctrine\\Migrations\\$3'"
    fi

    if [[ $1 == "rm" && $2 != -z ]]; then
        docker compose run --rm php-cli bash -c "rm './src/Domains/Admin/Authentication/Infrastructure/Repositories/Authentication/Doctrine/Migrations/$2.php'"
        exit;
    fi

    docker compose run --rm php-cli bash -c "ENTITY=admin php ./vendor/bin/doctrine-migrations migrations:$ARGS"
}

function bash()
{
    CONTAINER="${1:-php-cli}";
    echo $CONTAINER;

    docker compose run --rm $CONTAINER bash
}

function sh()
{
    CONTAINER="${1:-php-cli}";

    docker compose run --rm $CONTAINER sh
}

function artisan()
{
    docker compose run --rm php-cli bash -c "php artisan ${@:1}"
}

function composer()
{
    docker compose run --rm php-cli bash -c "composer ${@:1}"
}

function logs()
{
    docker compose logs "${@:1}"
}

function create-context()
{
    MODULE_NAME=${@:1}
    CONTEXT_NAME=${@:2}

    echo $MODULE_NAME;
    MODULE_NAMEN=$MODULE_NAME | grep -o '*()'
    echo $MODULE_NAMEN $CONTEXT_NAME;

    # mkdir -p "$PWD/src/Domains/$MODULE_NAME/$CONTEXT_NAME/{Application/$CONTEXT_NAME/Queries,Application/$CONTEXT_NAME/Commands,Domian/$CONTEXT_NAME/Services/Contracts,Infrastructure/$CONTEXT_NAME/Repositories/Doctrine,Presentation/Http/API/REST/Controllers}"
}

function nginx-restart()
{
    docker compose exec nginx bash -c "nginx -t && nginx -s reload && service nginx restart"
}

function generateSwaggerDocs()
{
    $PWD/vendor/bin/openapi $PWD/src/Domains/Admin -o $PWD/docs/admin.yaml --version 3.1.0
    $PWD/vendor/bin/openapi $PWD/src/Domains/Client -o $PWD/docs/client.yaml --version 3.1.0
}
