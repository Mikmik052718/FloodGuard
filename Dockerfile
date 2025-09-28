# Use PHP 8.2 CLI image
FROM php:8.2-cli

# Install system dependencies and PHP extensions
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libmysqlclient-dev \
    unzip \
    python3 \
    python3-pip \
 && docker-php-ext-install pdo_mysql mbstring intl \
 && rm -rf /var/lib/apt/lists/*

# Install Composer globally
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
 && php composer-setup.php --install-dir=/usr/local/bin --filename=composer \
 && rm composer-setup.php

# Set working directory
WORKDIR /app

# Copy project files
COPY . /app

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Install Python dependencies (if you have requirements.txt)
RUN if [ -f requirements.txt ]; then pip3 install -r requirements.txt; fi

# Expose port for CodeIgniter dev server
EXPOSE 8080

# Start the CI4 development server
CMD ["php", "spark", "serve", "--host=0.0.0.0", "--port=8080"]
