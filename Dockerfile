FROM node:22 AS frontend
WORKDIR /app
COPY package*.json ./
RUN npm install -g pnpm && pnpm install
COPY . /app

FROM bitnami/laravel AS base
WORKDIR /app
RUN apt-get update && apt-get install -y unzip git inotify-tools && rm -rf /var/lib/apt/lists/*
COPY . /app
COPY --from=frontend /app/node_modules /app/node_modules
RUN composer install --no-dev --optimize-autoloader

COPY .env.example .env

RUN php artisan key:generate

RUN chmod +x /app/hotreload.sh

ENTRYPOINT ["/app/hotreload.sh"]
