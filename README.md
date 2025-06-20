# Информационная система "Грузовозофф"

## Информация о проекте

1. Хост:

    ```
    http://localhost:9000
    ```

2. ФИО разработчика:

    ```
    cprkorzh
    ```

3. Номер компьютера:

    ```
    123456789
    ```

4. GitHub:

    ```
    https://github.com/username/laravel-17-06-2025
    ```

    Приложение работает на `http://localhost:9000`.

## Данные для входа администратора

-   **Логин**:

    ```
    admin
    ```

-   **Пароль**:
    ```
    gruzovik2024
    ```

## Запуск проекта через Docker Compose

### Требования

• Docker
• Docker Compose

### Шаги для запуска

1. Клонировать репозиторий:

    ```bash
    git clone https://github.com/username/laravel-17-06-2025.git
    cd laravel-17-06-2025
    ```

2. Скопировать переменные окружения из примера:

    ```
    cp .env.example .env
    ```

3. Запустить контейнеры:

    ```bash
    docker-compose up -d
    ```

    > [!Внимание]
    > Есть вероятность что контейнер ларавель не увидит ключ.
    > В таком случае перейдите в контейнер:
    >
    > ```
    > docker exec -it <id_container> /bin/bash
    > ```
    >
    > Выполните:
    >
    > ```
    > php artisan key:generate
    > ```
    >
    > После - обновите страницу

4. Выполнить миграции и заполнить базу данных:
    ```bash
    docker exec -it laravel-laravel-1 php /app/artisan migrate:fresh --seed
    ```
5. Открыть приложение в браузере:
    ```
    http://localhost:9000
    ```

## Технологии

-   Laravel
-   MySQL
-   Bootstrap 5
-   Docker

## Структура базы данных

-   **users**: Информация о пользователях
-   **requests**: Заявки на перевозку грузов
-   **reviews**: Отзывы пользователей о выполненных заказах

## Дополнительная информация

Для доступа к панели администрирования базы данных (Adminer) используйте:

```
http://localhost:8081
```

-   **Сервер**:
    ```
    db
    ```
-   **Пользователь**:
    ```
    root
    ```
-   **Пароль**:
    ```
    123123
    ```
-   **База данных**:
    ```
    laravel_db
    ```
