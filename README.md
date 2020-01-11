<p align="center"><img src="https://res.cloudinary.com/dtfbvvkyp/image/upload/v1566331377/laravel-logolockup-cmyk-red.svg" width="400"></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>
</p>

## About Delivery

A restfull api for cities delivery

## How to use

Install the project's dependencies by running `composer install` in your terminal.

create and modify the .env file.

```
APP_NAME=Laravel
APP_ENV=local
APP_KEY=base64:X64ST92vnBHp3Wb4tufvubViAbja355QyPw4uUOcerQ=
APP_DEBUG=true
APP_URL=http://localhost:8000

LOG_CHANNEL=stack

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=projectA
DB_USERNAME=root
DB_PASSWORD=
```

you should create a database using PHPMYADMIN with the same name montionned in the .env file.

generate the key with `php artisan key:generate`.

create the database tables by running `php artisan migrate`.

and finally run the server `php artisan serve`.

## API ENDPOINTS

```
post -> 'api/city'
Request parameters {name, slug}
```

```
post -> 'api/delivery-times'
Request parameters {span}
```

```
post -> 'api/city/{city_id}/delivery-times'
Request parameters {id}
id: id of the delivery time
```

```
post -> 'api/city/{city_id}/exclude'
Request parameters { [id, date] }
id: id of the delivery time to exclude
date: date to exclude
Example: 
{
"0": ["1", "2020-01-03"],
"1": ["3", "2020-01-03"]
}
```

```
post -> 'api/city/{city_id}/excludeall'
Request parameters { date }
date: date to exclude
Example: 
{
"0": "2020-01-03",
"1": "2020-01-03"
}
```

```
post -> 'api/city/{city_id}/delivery-dates-times/{number_of_days_to_get}'
```



