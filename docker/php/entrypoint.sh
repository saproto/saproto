#!/bin/sh
set -e

# Sync public assets (Vite build output, storage link target) to the shared volume
if [ -d /var/www-public ]; then
    cp -r /var/www/public/. /var/www-public/
    php artisan storage:link --force || true
fi

# Wait for MySQL to accept connections (up to ~60s)
for i in $(seq 1 30); do
    if php artisan db:show >/dev/null 2>&1; then
        break
    fi
    echo "Waiting for database... ($i)"
    sleep 2
done

php artisan migrate --force
php artisan optimize

exec "$@"
