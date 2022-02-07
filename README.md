# Birdboard

Website to administrate projects with other people. 
You can add tasks to any project, edit its description,
invite other people, etc.

TDD project following this course from Laracast:
[link](https://laracasts.com/series/build-a-laravel-app-with-tdd/)

### Installation

- Copy the .env.example to .env `cp .env.example .env`
- Execute `docker-compose build && docker-compose up -d`
- Once built, get into the birdboard_php service:
- `docker exec -it birdboard_php /bin/sh` and execute:
- `composer install`
- `php artisan key:generate`
- `php artisan migrate --seed`
- Finally go to `http://birdboard.fuf.me`
- If it continues asking you for the key, do the following:
- `docker-compose down` and then `docker-compose up -d`
