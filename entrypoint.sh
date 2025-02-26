#!/bin/bash
set -e

# Start Redis Server
service redis-server start

# Start supervisor in the background
/usr/bin/supervisord -c /etc/supervisor/conf.d/laravel-worker.conf &

sleep 3


# Run migrations
 php artisan migrate --path=database/migrations/2025_01_01_173028_create_therapy_table.php

php artisan migrate --force

php artisan db:seed --force


# Clear and cache config
php artisan optimize

# meilisearch --master-key=LGUC3FIdLOTUEFkFGkrkTha7QNOK4K4BNj2ZAhr7Ouw &

# sleep 10

php artisan queue:restart

#Index the Models for the search engine
php artisan scout:import "\App\Models\Parents"
php artisan scout:import "\App\Models\children"

# # ✅ Start Laravel’s built-in server
# php artisan serve --host=0.0.0.0 --port=8000

# Start Apache in foreground
exec apache2-foreground

