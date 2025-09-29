# 1. Base PHP image
FROM php:8.2-apache

# 2. Set working directory
WORKDIR /app

# 3. Install system dependencies
RUN apt-get update && apt-get install -y \
    libpng-dev libonig-dev libxml2-dev libmariadb-dev-compat libicu-dev \
    unzip git curl \
 && docker-php-ext-install pdo_mysql mbstring intl \
 && rm -rf /var/lib/apt/lists/*

# 4. Enable Apache Rewrite
RUN a2enmod rewrite

# 5. Install Composer globally
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# 6. Copy composer files first (for caching)
COPY composer.json composer.lock /app/

# 7. Install PHP dependencies (no dev packages)
RUN composer clear-cache \
 && composer install --no-interaction --optimize-autoloader --no-dev

# 8. Copy the rest of the application including .env
COPY . /app

# 9. Set permissions
RUN chown -R www-data:www-data /app \
 && chmod -R 755 /app \
 && chmod -R 777 /app/writable

# 10. Configure Apache
RUN printf '%s\n' \
 "<VirtualHost *:80>" \
 "    DocumentRoot /app/public" \
 "    <Directory /app/public>" \
 "        AllowOverride All" \
 "        Require all granted" \
 "        DirectoryIndex index.php" \
 "    </Directory>" \
 "</VirtualHost>" \
 > /etc/apache2/sites-available/000-default.conf

# 11. Expose port 80
EXPOSE 80

# 12. Start Apache
CMD ["apache2-foreground"]
