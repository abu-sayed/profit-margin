# profit-margin
Profit margin

## Prerequisite
[docker](https://www.docker.com/) and [docker-compose](https://docs.docker.com/compose/)

## Installing packages
`docker run --rm -v $PWD:/app composer install`

## Generating autoload files
`docker run --rm -v $PWD:/app composer dump-autoload`

## Running project
`docker-compose up`

## Running unit tests
Make sure the project is running. Then run the following command.

`docker-compose exec app bash -c "php ./vendor/bin/phpunit ./src/"`