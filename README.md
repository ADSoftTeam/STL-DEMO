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
4. 