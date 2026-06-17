FROM php:8.2-cli

RUN apt-get update && apt-get install -y \
    libzip-dev \
    libxml2-dev \
    libonig-dev \
    curl \
    unzip \
    && docker-php-ext-install pdo pdo_mysql mbstring xml zip bcmath \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app

COPY . .

RUN composer install --no-dev --optimize-autoloader --no-interaction

COPY docker-entrypoint.sh /usr/local/bin/docker-entrypoint.sh
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

EXPOSE 8080

CMD ["/usr/local/bin/docker-entrypoint.sh"]
