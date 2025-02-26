# Use official PHP image with Apache
FROM php:8.2-apache

# Install system dependencies and PHP extensions for Laravel, Redis, and Meilisearch
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    libicu-dev \
    zip \
    git \
    libpq-dev \
    supervisor \
    redis-server \
    curl \
    gnupg \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql pdo_pgsql intl zip \
    && pecl install redis && docker-php-ext-enable redis

# Install Node.js and npm
RUN mkdir -p /etc/apt/keyrings && \
    curl -fsSL https://deb.nodesource.com/gpgkey/nodesource-repo.gpg.key | gpg --dearmor -o /etc/apt/keyrings/nodesource.gpg && \
    echo "deb [signed-by=/etc/apt/keyrings/nodesource.gpg] https://deb.nodesource.com/node_20.x nodistro main" | tee /etc/apt/sources.list.d/nodesource.list && \
    apt-get update && \
    apt-get install -y nodejs && \
    npm install -g npm@latest

# Verify Node.js and npm installation
RUN node -v && npm -v

# Enable Apache rewrite module
RUN a2enmod rewrite

# Set working directory
WORKDIR /var/www

# Copy package.json and package-lock.json first (for better caching)
COPY package*.json ./

# Install npm dependencies
RUN npm ci

# Copy Laravel app files
COPY . .

# Build assets with Vite
RUN npm run build

# Set Apache to serve from Laravel's public directory
RUN sed -i 's|DocumentRoot /var/www/html|DocumentRoot /var/www/public|' /etc/apache2/sites-available/000-default.conf

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Prepare cache directories and set permissions
RUN mkdir -p storage/framework/views storage/framework/cache storage/logs bootstrap/cache && \
    chmod -R 775 storage bootstrap/cache && \
    chown -R www-data:www-data storage bootstrap/cache

# Clear old vendor files and install Composer dependencies
RUN rm -rf vendor composer.lock && \
    composer install --no-interaction --no-dev --prefer-dist

# Setup Supervisor directories and logs
RUN mkdir -p /var/log/supervisor /var/run/supervisord && \
    touch /var/log/supervisor/supervisord.log /var/log/supervisor/worker.log && \
    chmod -R 777 /var/log/supervisor /var/run/supervisord

# Setup Supervisor for Laravel Queue Workers
COPY laravel-worker.conf /etc/supervisor/conf.d/laravel-worker.conf

# Expose necessary ports (Apache, Redis)
EXPOSE 80 6379

# Copy entrypoint script and make it executable
COPY entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/entrypoint.sh

# Start using the entrypoint
ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
