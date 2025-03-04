#!/bin/bash
set -e

# Start Redis Server
service redis-server start

# Start supervisor in the background
/usr/bin/supervisord -c /etc/supervisor/conf.d/laravel-worker.conf &

sleep 3

# Clear and cache config
php artisan optimize

#restart queue
php artisan queue:restart

# Start Apache in foreground
exec apache2-foreground

