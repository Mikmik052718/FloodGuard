# 1. Base PHP image
FROM php:8.2-cli

# 2. Set working directory
WORKDIR /app

# 3. Install system dependencies including ICU for intl extension
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libmariadb-dev-compat \
    libicu-dev \
    unzip \
    python3 \
    python3-pip \
    git \
    curl \
 && docker-php-ext-install pdo_mysql mbstring intl \
 && rm -rf /var/lib/apt/lists/*

# 4. Install Composer globally
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# 5. Copy composer files first to leverage caching
COPY composer.json composer.lock /app/

# 6. Install PHP dependencies according to composer.lock
RUN composer install --no-dev --optimize-autoloader --ignore-platform-reqs

# 7. Copy the rest of the application including .env
COPY . /app

# 8. Install Python dependencies only if requirements.txt exists
RUN if [ -f requirements.txt ]; then pip3 install --no-cache-dir -r requirements.txt || true; fi

# 9. Expose port (EasyPanel or CI4 default)
EXPOSE 8080

# 10. Start CodeIgniter development server
CMD ["php", "spark", "serve", "--host=0.0.0.0", "--port=8080"]
