# README #

### Docker ###

* docker-compose build
* docker-compose up -d
* docker-compose run php_test1 composer install
* docker-compose run php_test1 chmod -R 777 var
* docker-compose run php_test1 php bin/console doctrine:database:create
* docker-compose run php_test1 php bin/console doctrine:migrations:migrate
* .env and .docker/.env i already have committed 


### Endpoints 
* Swagger
  http://localhost:8091/api/doc (swagger не повністю готовий тільки список ендпоінтів)
* Create debit: 
    http://localhost:8091/api/transaction/debit
* Create debit: 
    http://localhost:8091/api/transaction/credit

### Details ###

* Для уникнення паралельних запитів додав Lock `https://symfony.com/doc/current/components/lock.html`.
Це позволить уникнути виконання запиту якшо не виконався попередній запит. 
(це має працювати через Redis, але тут я зробив через дефолтнй стандартний store )

* Процес сторення транзакцій і калькулювання балансу(BalanceListener) знаходиться в транзакції.

* Присутня валідація для реквесту 


