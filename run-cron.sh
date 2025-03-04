#!/bin/bash
# Ensure this file has executable permissions: chmod +x run-cron.sh

# This loop runs the Laravel scheduler every minute
while [ true ]
do
    echo "Running the scheduler..."
    php artisan schedule:run --verbose --no-interaction
    sleep 60
done
