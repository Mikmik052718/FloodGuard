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

# 6. Copy everything first (so vendor will persist)
COPY . /app

# 7. Install PHP dependencies, including phpdotenv
RUN composer clear-cache \
 && composer install --no-interaction --optimize-autoloader \
 && composer require vlucas/phpdotenv --no-interaction --optimize-autoloader

# 8. Set permissions
RUN chown -R www-data:www-data /app \
 && chmod -R 755 /app \
 && chmod -R 777 /app/writable

# 9. Configure Apache
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

# 10. Expose port 80
EXPOSE 80

# 11. Start Apache
CMD ["apache2-foreground"]
