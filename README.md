
## Installation

### clone repo and move inside project

```sh
git clone https://github.com/redgitnum/laravel_users_crud.git
cd laravel_users_crud
```

### install dependencies

```sh
composer install
```
rename **.env.example** to **.env** (or create .env from copying .env.example)
 

### generate appkey

```sh
php artisan key:generate
```

### change APP_DEBUG to false inside .env

```sh
APP_DEBUG=true
```

### create database & configure database connection inside .env
#### example
```sh
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel_users_crud
DB_USERNAME=root
DB_PASSWORD=
``` 

### run migrations

```sh
php artisan migrate
```
### seed the database
```sh
php artisan db:seed
```
### start server
```sh
php artisan serve
```
if your serve location is http://127.0.0.1:8000
then you can use routes below, otherwise adapt the urls accordingly

#### swagger documentation api -> http://127.0.0.1:8000/api

## API routes
|action| method | url |
|--|--|--|
|index| GET | http://127.0.0.1:8000/api/users |
|create| POST | http://127.0.0.1:8000/api/users |
|update| PUT | http://127.0.0.1:8000/api/users/{id} |
|delete| DESTROY| http://127.0.0.1:8000/api/users/{id} |
  

### Usage
Best used with Postman/Insomnia REST clients for fast route testing.


### Logs
Logs are saved in logs table, every change to user(create, update, delete) triggers observer that creates log based on action and saves all changes, old data and new data, that corresponds to models where the changes occured.
