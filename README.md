# README #

### Docker ###

* docker-compose build
* docker-compose up -d
* docker-compose run php_test1 composer install
* docker-compose run php_test1 chmod -R 777 var/cache
* docker-compose run php_test1 php bin/console doctrine:database:create
* docker-compose run php_test1 php bin/console doctrine:migrations:migrate
* .env and .docker/.env i already have committed 


### Endpoints 
* Swagger
  http://localhost:8091/api/doc
* Create debit: 
    http://localhost:8091/api/transaction/debit
* Create debit: 
    http://localhost:8091/api/transaction/credit

### Details ###

* Для уникнення параленлних запитів додав Lock `https://symfony.com/doc/current/components/lock.html`.
Це позволить уникнути виконання запиту якшо не виконався попередній запит. 
(це має пацювати через Redis, але тут я зробив через дефолтнй стандартний store )

