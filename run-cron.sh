#!/bin/bash

trap "exit" SIGINT SIGTERM

echo "Starting Laravel Scheduler..."

while true
do
    echo "Running scheduler at $(date)..."
    php /var/www/artisan schedule:run --verbose --no-interaction
    sleep 60
done
