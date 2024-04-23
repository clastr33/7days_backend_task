# Test task
Symfony 5.4.34, PHP 7.4.33

## Setup

Make sure you have [Composer installed](https://getcomposer.org/download/)
and then run:
```
composer install
```
Run the project by docker-compose.
```
docker-compose up
```
Run to install the database:
```
docker-compose exec php-fpm bash -c "make install-database"
```
The file docker-compose.yaml contains the ports, which you can access the website and PhpMyAdmin by.


