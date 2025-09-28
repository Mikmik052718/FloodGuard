# Start from official PHP 8.2 CLI image
FROM php:8.2-cli

# Set working directory
WORKDIR /app

# Install system dependencies including ICU for intl extension
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libmariadb-dev-compat \
    libicu-dev \           # <-- required for intl
    unzip \
    python3 \
    python3-pip \
    git \
    curl \
 && docker-php-ext-install pdo_mysql mbstring intl \
 && rm -rf /var/lib/apt/lists/*

# Install Composer globally
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copy the application code
COPY . /app

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader --ignore-platform-reqs

# Install Python dependencies only if requirements.txt exists
RUN if [ -f requirements.txt ]; then pip3 install --no-cache-dir -r requirements.txt || true; fi

# Expose the port (EasyPanel uses $PORT)
EXPOSE 8080

# Start CodeIgniter development server
CMD ["php", "spark", "serve", "--host=0.0.0.0", "--port=8080"]
