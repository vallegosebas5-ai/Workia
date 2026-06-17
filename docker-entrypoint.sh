#!/bin/bash
set -e

APP_KEY_VALUE="${APP_KEY:-base64:KmV61al/MolDhFgOBnMFcjlUvS+pZXC2vChZetbS4Yc=}"

# Railway MySQL plugin injects MYSQL_HOST, MYSQL_DATABASE, MYSQL_USER, MYSQL_PASSWORD
DB_HOST_VALUE="${MYSQL_HOST:-${DB_HOST:-127.0.0.1}}"
DB_PORT_VALUE="${MYSQL_PORT:-${DB_PORT:-3306}}"
DB_DATABASE_VALUE="${MYSQL_DATABASE:-${DB_DATABASE:-workia}}"
DB_USERNAME_VALUE="${MYSQL_USER:-${DB_USERNAME:-root}}"
DB_PASSWORD_VALUE="${MYSQL_PASSWORD:-${DB_PASSWORD}}"

cat > /app/.env << EOF
APP_NAME=Workia
APP_ENV=production
APP_KEY=${APP_KEY_VALUE}
APP_DEBUG=false
APP_URL=${APP_URL:-http://localhost:8080}
APP_LOCALE=es
APP_FALLBACK_LOCALE=es

DB_CONNECTION=mysql
DB_HOST=${DB_HOST_VALUE}
DB_PORT=${DB_PORT_VALUE}
DB_DATABASE=${DB_DATABASE_VALUE}
DB_USERNAME=${DB_USERNAME_VALUE}
DB_PASSWORD=${DB_PASSWORD_VALUE}

SESSION_DRIVER=file
SESSION_LIFETIME=120
CACHE_STORE=file
QUEUE_CONNECTION=sync

LOG_CHANNEL=stack
LOG_LEVEL=error

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
