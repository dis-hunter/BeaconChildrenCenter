# Use official PHP image with Apache
FROM php:8.2-apache

# Install system dependencies and PHP extensions for Laravel & Redis
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
    npm install -g npm@latest \

# Verify Node.js and npm installation
RUN node -v && npm -v

# Enable Apache rewrite module
RUN a2enmod rewrite

# Set working directory
WORKDIR /var/www

# Copy Laravel app files
COPY . .

# Set Apache to serve from Laravel's public directory
RUN sed -i 's|DocumentRoot /var/www/html|DocumentRoot /var/www/public|' /etc/apache2/sites-available/000-default.conf

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Create the cache directory and set permissions
RUN mkdir -p storage/framework/views && chmod -R 775 storage/framework/views

RUN composer config --global process-timeout 2000


RUN rm -rf /var/www/vendor composer.lock
RUN composer install --no-interaction --no-dev --prefer-dist

#Install npm dependencies
RUN npm install

#Setup Supervisor configuration
COPY supervisord.conf /etc/supervisor/conf.d/supervisord.conf
RUN mkdir -p /var/log/supervisor
RUN touch /var/log/supervisor/supervisord.log
RUN touch /var/log/supervisor/worker.log

# Set proper permissions for Laravel directories
RUN chown -R www-data:www-data /var/www && \
    chown -R www-data:www-data /var/log/supervisor \
    chmod -R 775 storage bootstrap/cache

# Expose ports for Apache and Redi
EXPOSE 80 6379

COPY entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/entrypoint.sh

ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
