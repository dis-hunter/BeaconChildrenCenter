#!/bin/bash
set -e

# Start Redis Server
service redis-server start

# Run migrations
php artisan migrate --force

# Clear and cache config
php artisan optimize

until curl -s -f "${MEILISEARCH_HOST}/health" > /dev/null; do
    echo "Waiting for Meilisearch to be ready..."
    sleep 2
done

php artisan scout:import "/App/Models/Parents"

php artisan scout:import "/App/Models/children"

# Start Apache in foreground
apache2-foreground
