## План работ
1. Разворачиваем laravel composer create-project laravel/laravel stl, добавим библиотеку composer require square1/laravel-idempotency, composer require predis/predis
2. Настраиваем env, фабрика php artisan make:factory SlotFactory
3. php artisan key:generate
4. php artisan migrate --seed
5. создаем миграции и сидеры, php artisan make:migration create_slots_table, php artisan make:migration create_holds_table, применяем php artisan migrate
6. создаем модели  php artisan make:model Slot, php artisan make:model Hold
7. прописываем роуты (с группами), для начала -  php artisan install:api
8. создаем сервисный слой для работы с слотами, кешами
9. создаем контроллеры с валидацией
10. Тестируем

### Развертывание

Считаем что установлены все необходимые инструменты и утилиты (LEMP/LAMP, PHP 8.2. , composer, curl, git итд)

1. Клонируем репозиторий git clone https://github.com/ADSoftTeam/STL-DEMO.git stl
2. ```
composer install
cp .env.example .env - прописываем наши креды
php artisan key:generate
```
3. php artisan migrate --seed
4. Для документирования устанавливаем npm install apidoc -g
5. Генерация документации для API

Для этого на компьютере должен быть установлен [apidoc](http://apidocjs.com/).

Инсталяция
```
npm install apidoc -g
```

Генерация документации
```
apidoc -i app -o public/documentation
```

6. Примеры запросов

```
curl --location 'stl/api/slots/availability' --header 'Accept: application/json'

curl --location --request POST 'stl/api/slots/1/hold' --header 'Accept: application/json' --header 'Idempotency-Key: 123'

curl --location --request POST 'stl/api/holds/5/confirm' --header 'Accept: application/json'

curl --location --request DELETE 'stl/api/holds/5' --header 'Accept: application/json'
```
