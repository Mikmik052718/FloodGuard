# 1. Base PHP image (use Apache, not CLI, for production)
FROM php:8.2-apache

# 2. Set working directory
WORKDIR /app

# 2.1 Force PHP to display errors in development (important for debugging 500s)
RUN echo "display_errors=On" > /usr/local/etc/php/conf.d/display-errors.ini \
    && echo "error_reporting=E_ALL" >> /usr/local/etc/php/conf.d/display-errors.ini

# 3. Install system dependencies including ICU for intl extension
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libmariadb-dev-compat \
    libicu-dev \
    unzip \
    git \
    curl \
 && docker-php-ext-install pdo_mysql mbstring intl \
 && rm -rf /var/lib/apt/lists/*

# 4. Enable Apache Rewrite (needed for CI4 pretty URLs)
RUN a2enmod rewrite

# 5. Install Composer globally
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# 6. Copy composer files first to leverage caching
COPY composer.json composer.lock /app/

# 7. Install PHP dependencies according to composer.lock
RUN composer install --no-dev --optimize-autoloader --ignore-platform-reqs

# 8. Copy the rest of the application including .env
COPY . /app

# 9. Set permissions for CI4 (writable dirs for logs/sessions/uploads)
RUN chown -R www-data:www-data /app \
    && chmod -R 755 /app \
    && chmod -R 777 /app/writable

# 10. Configure Apache to serve from /app/public
RUN printf '%s\n' \
    "<VirtualHost *:80>" \
    "    DocumentRoot /app/public" \
    "    <Directory /app/public>" \
    "        AllowOverride All" \
    "        Require all granted" \
    "    </Directory>" \
    "</VirtualHost>" \
    > /etc/apache2/sites-available/000-default.conf

# 11. Expose port 80 (Easypanel default)
EXPOSE 80

# Apache will start automatically when the container runs
