#!/bin/bash

APP_KEY_VALUE="${APP_KEY:-base64:KmV61al/MolDhFgOBnMFcjlUvS+pZXC2vChZetbS4Yc=}"

DB_HOST_VALUE="${DB_HOST:-127.0.0.1}"
DB_PORT_VALUE="${DB_PORT:-3306}"
DB_DATABASE_VALUE="${DB_DATABASE:-workia}"
DB_USERNAME_VALUE="${DB_USERNAME:-root}"
DB_PASSWORD_VALUE="${DB_PASSWORD}"

# Force correct DB vars in OS environment so Laravel's createImmutable() dotenv uses mysql
export DB_CONNECTION=mysql
export DB_HOST="${DB_HOST_VALUE}"
export DB_PORT="${DB_PORT_VALUE}"
export DB_DATABASE="${DB_DATABASE_VALUE}"
export DB_USERNAME="${DB_USERNAME_VALUE}"
export DB_PASSWORD="${DB_PASSWORD_VALUE}"
export APP_KEY="${APP_KEY_VALUE}"

echo "=== DB CONFIG ==="
echo "HOST: ${DB_HOST_VALUE} PORT: ${DB_PORT_VALUE} DB: ${DB_DATABASE_VALUE} USER: ${DB_USERNAME_VALUE}"

cat > /app/.env << EOF
APP_NAME=Workia
APP_ENV=production
APP_KEY=${APP_KEY_VALUE}
APP_DEBUG=${APP_DEBUG:-false}
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

php artisan route:cache || echo "WARN: route:cache failed"
php artisan view:cache || echo "WARN: view:cache failed"
php artisan migrate --force || echo "WARN: migrate failed"
php artisan db:seed --class=DatabaseSeeder --force || echo "WARN: seed failed"
php artisan storage:link --force || echo "WARN: storage:link failed"
exec php artisan serve --host=0.0.0.0 --port=8080
