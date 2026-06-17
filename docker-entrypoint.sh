#!/bin/bash
set -e

cat > /app/.env << EOF
APP_NAME=${APP_NAME:-Workia}
APP_ENV=${APP_ENV:-production}
APP_KEY=${APP_KEY}
APP_DEBUG=${APP_DEBUG:-false}
APP_URL=${APP_URL:-http://localhost:8080}
APP_LOCALE=${APP_LOCALE:-es}
APP_FALLBACK_LOCALE=${APP_FALLBACK_LOCALE:-es}

DB_CONNECTION=${DB_CONNECTION:-mysql}
DB_HOST=${DB_HOST:-127.0.0.1}
DB_PORT=${DB_PORT:-3306}
DB_DATABASE=${DB_DATABASE:-workia}
DB_USERNAME=${DB_USERNAME:-root}
DB_PASSWORD=${DB_PASSWORD}

SESSION_DRIVER=${SESSION_DRIVER:-file}
SESSION_LIFETIME=120
CACHE_STORE=${CACHE_STORE:-file}
QUEUE_CONNECTION=${QUEUE_CONNECTION:-sync}

LOG_CHANNEL=stack
LOG_LEVEL=${LOG_LEVEL:-error}

MAIL_MAILER=log
MAIL_FROM_ADDRESS=noreply@workia.bo
MAIL_FROM_NAME=Workia

FILESYSTEM_DISK=local
BROADCAST_CONNECTION=log
EOF

php artisan route:cache
php artisan view:cache
php artisan migrate --force
php artisan db:seed --class=DatabaseSeeder --force
php artisan storage:link --force
exec php artisan serve --host=0.0.0.0 --port=8080
