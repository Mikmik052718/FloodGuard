# 1. Base PHP image (use Apache, not CLI, for production)
FROM php:8.2-apache

# 2. Set working directory
WORKDIR /app

# 2.5. Set timezone to Asia/Manila
ENV TZ=Asia/Manila
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

# 3. Install system dependencies including ICU for intl extension and Python
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libmariadb-dev-compat \
    libicu-dev \
    unzip \
    git \
    curl \
    python3 \
    python3-venv \
    cron \
    && docker-php-ext-install pdo_mysql mysqli mbstring intl \
    && rm -rf /var/lib/apt/lists/*

# 4. Enable Apache Rewrite (needed for CI4 pretty URLs)
RUN a2enmod rewrite

# 5. Install Composer globally
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# 6. Copy composer files first to leverage caching
COPY composer.json composer.lock /app/

# 7. Install PHP dependencies according to composer.lock (force reinstall)
RUN rm -rf /app/vendor \
    && composer clear-cache \
    && composer install --optimize-autoloader --ignore-platform-reqs --no-cache \
    && ls -la /app/vendor \
    && ls -la /app/vendor/react || true \
    && ls -la /app/vendor/react/promise || true

# 8. Copy the rest of the application including .env
COPY . /app

# 9. Create Python virtual environment and install dependencies
RUN python3 -m venv /opt/venv && /opt/venv/bin/pip install --no-cache-dir -r requirements.txt

# 10. Make Python scripts executable
RUN chmod +x python/*.py

# 11. Set permissions for CI4 (writable dirs for logs/sessions/uploads)
RUN chown -R www-data:www-data /app \
    && chmod -R 755 /app \
    && chmod -R 777 /app/writable

# 12. Set up cron job for autopost
COPY docker/cron/autopost /etc/cron.d/autopost
RUN chmod 0644 /etc/cron.d/autopost && crontab /etc/cron.d/autopost

# 10. Configure Apache to serve from /app/public
RUN cat > /etc/apache2/sites-available/000-default.conf <<EOF
<VirtualHost *:80>
    DocumentRoot /app/public
    <Directory /app/public>
        AllowOverride All
        Require all granted
        DirectoryIndex index.php
    </Directory>
</VirtualHost>
EOF

# 13. Expose port 80 (Easypanel default)
EXPOSE 80

# 14. Copy and make start script executable
COPY docker/cron/start.sh /usr/local/bin/start.sh
RUN chmod +x /usr/local/bin/start.sh

# 15. Start both cron and Apache
CMD ["/usr/local/bin/start.sh"]
