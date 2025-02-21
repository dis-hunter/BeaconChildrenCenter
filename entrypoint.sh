#!/bin/bash
set -e

# Start Redis Server
service redis-server start

#buld assets
npm run build

# Clear and cache config
php artisan optimize

#start the laravel queues worker
supervisord

until curl -s -f "${MEILISEARCH_HOST}/health" > /dev/null; do
    echo "Waiting for Meilisearch to be ready..."
    sleep 2
done

#Index the Models for the search engine
php artisan scout:import "\App\Models\Parents"
php artisan scout:import "\App\Models\children"

# Start Apache in foreground
exec apache2-foreground
