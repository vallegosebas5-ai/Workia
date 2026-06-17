FROM php:8.2-cli

RUN apt-get update && apt-get install -y \
    libzip-dev \
    libxml2-dev \
    curl \
    unzip \
    && docker-php-ext-install pdo pdo_mysql mbstring xml zip bcmath \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app

COPY . .

RUN composer install --no-dev --optimize-autoloader --no-interaction

EXPOSE 8080

CMD php artisan config:clear \
    && php artisan route:cache \
    && php artisan view:cache \
    && php artisan migrate --force \
    && php artisan db:seed --class=DatabaseSeeder --force \
    && php artisan storage:link --force \
    && php artisan serve --host=0.0.0.0 --port=8080
