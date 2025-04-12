<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>
<h1 align="center">Car Workshop System</h1>

# HOW TO RUN

## install depedencies

before running the app make sure you install the required depedencies by running the following command

_note: make sure composer is installed on your machine_
[install composer](https://getcomposer.org/doc/00-intro.md)

```sh
composer install
```

## run migration

```sh
php artisan migrate
```

## running localy

```sh
php artisan serve
```

## running on docker compose

using laravel sail command

```sh
./vendor/bin/sail up -d
```

or using docker compose command

```sh
docker compose up -d
```

# Documentation

## Entity Relationship Diagram (ERD)

https://dbdiagram.io/d/car-workshop-system-67f95c5a4f7afba184493117
