#!/bin/bash
set -e

# Start Redis Server
service redis-server start

# Start supervisor in the background
/usr/bin/supervisord -c /etc/supervisor/conf.d/laravel-worker.conf &

sleep 3

# Clear and cache config
php artisan optimize

meilisearch --master-key=${MEILISEARCH_KEY} --http-addr '0.0.0.0:7700' &

sleep 10

#Index the Models for the search engine
php artisan scout:import "\App\Models\Parents"
php artisan scout:import "\App\Models\children"

php artisan queue:restart

# Start Apache in foreground
exec apache2-foreground

