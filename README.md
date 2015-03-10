The Librarian
========================
Реализация списка авторов книг в библиотеке.

## Установка

```
git clone https://github.com/starcode-ru/library.git 
```

В **app/config/parameters.yml** указать БД.


Применить миграцию

```
php app/console doctrine:migrations:migrate
```

Загрузить фикстуры:
```
php app/console doctrine:fixtures:load
```


## Тестирование

В **app/config/config_test.yml** указать тестовую БД.

В **behat.yml** указать base_url


Применить миграцию для тестовой БД

```
php app/console doctrine:migrations:migrate --env test
```

Запуск тестов:

```
bin/behat
```