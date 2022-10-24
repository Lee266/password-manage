## About API Laravel 9 (Lastest version of Laravel) 07/28/2022

Docker Environments

- Nginx 1.17

- NodeJs 16.x

- PHP 8.0

- mySQL 5.7

Run Docker and project

- cd docker_nginx/docker-compose/docker-desktop/

- run cmd or powershell here

- run docker-compose up -d --build

- run docker exec -it --user=dev_user api_laravel9_php-fpm bash

[ If the first time ]

- cp .env.example .env

- composer install

- php artisan migrate:fresh --seed
