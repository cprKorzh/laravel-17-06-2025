#!/bin/bash

echo "Запуск Laravel с hot reload..."

# Проверка и генерация APP_KEY, если он отсутствует
if ! grep -q '^APP_KEY=' .env || [ -z "$(grep '^APP_KEY=' .env | cut -d '=' -f 2)" ]; then
    echo "APP_KEY не найден или пустой, генерируем новый ключ..."
    php artisan key:generate
    echo "Ключ приложения сгенерирован."
fi

# Инициализация
php artisan config:clear
php artisan route:clear  
php artisan view:clear
php artisan migrate

# Запуск Vite dev server
echo "Запуск Vite dev server..."
npm run dev -- --host=0.0.0.0 --port=5173 &
VITE_PID=$!

# Запуск Laravel сервера
echo "Запуск Laravel сервера..."
php artisan serve --host=0.0.0.0 --port=${APP_PORT:-9000} &
SERVER_PID=$!

echo "Laravel сервер запущен (PID: $SERVER_PID)"
echo "Vite dev server запущен (PID: $VITE_PID)"
echo "Отслеживание изменений..."

# Функция для остановки всех процессов
cleanup() {
    echo "Остановка серверов..."
    kill $SERVER_PID 2>/dev/null
    kill $VITE_PID 2>/dev/null
    exit
}

# Обработка сигналов завершения
trap cleanup SIGTERM SIGINT

# Мониторинг файлов
while inotifywait -r -e modify,create,delete,move app/ routes/ config/ database/ resources/ 2>/dev/null; do
    echo "Обнаружены изменения в PHP, перезапуск Laravel..."
    
    # Остановка Laravel сервер (Vite остается работать)
    kill $SERVER_PID 2>/dev/null
    sleep 1
    
    # Очищаем кеши
    php artisan config:clear
    php artisan route:clear
    php artisan view:clear
    
    # Запуск нового Laravel сервера
    php artisan serve --host=0.0.0.0 --port=${APP_PORT:-9000} &
    SERVER_PID=$!
    
    echo "Laravel сервер перезапущен (PID: $SERVER_PID)"
done