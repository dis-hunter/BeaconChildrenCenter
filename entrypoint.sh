#!/bin/bash
set -e

# Start Redis Server
service redis-server start

# Clear and cache config
php artisan optimize

#enable the laravel queues worker
/usr/bin/supervisord -n -c /etc/supervisor/supervisord.conf &

until curl -s -f "${MEILISEARCH_HOST}/health" > /dev/null; do
    echo "Waiting for Meilisearch to be ready..."
    sleep 2
done

php artisan scout:import "\App\Models\Parents"

php artisan scout:import "\App\Models\children"

# Start Apache in foreground
apache2-foreground
