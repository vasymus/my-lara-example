# Laravel application

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

# Local deployment

## Installation

### First time

```shell
# create .env file
cp ./.env.example ./.env

# build and run docker-compose
docker-compose up -d --build

# enter `app` container
docker-compose exec app bash

# install php dependencies
composer install

# generate APP_KEY in .env
php artisan key:generate

# create link between ./storage/app/public and ./public/storage
php artisan storage:link

# run migrations
php artisan migrate

# seed data
SEEDERS_CLEAR_DATA=true php artisan db:seed

# install node_modules
npm install

# one-time build webpack
npm run dev
# or
# build and watch webpack
npm run watch

# to exit container
exit

# stop docker-compose when finish working
docker-compose down
```

### Git checkout

```shell

# build and run docker-compose
docker-compose up -d --build
# or
# without build (especially, when there were no changes in docker folder)
docker-compose up -d

# enter `app` container
docker-compose exec app bash

# run migrations with seeds
php artisan migrate --seed

# install node_modules
npm install

# one-time build webpack
npm run dev
# or
# build and watch webpack
npm run watch

# to exit container
exit

# stop docker-compose when finish working
docker-compose down
```
