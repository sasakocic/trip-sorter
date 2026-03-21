FROM php:8.3-cli

WORKDIR /app

# Install git, unzip, curl and required extensions for composer
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    curl \
    && rm -rf /var/lib/apt/lists/*

# Copy project files first to leverage Docker cache
COPY . /app/

# Install composer dependencies (update lock file if needed)
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer update --no-interaction --prefer-dist --optimize-autoloader

# Run tests via composer vendor binary
CMD ["vendor/bin/phpunit", "tests", "--coverage-text", "--coverage-clover=coverage.xml", "--colors", "always", "--testdox", "--no-interaction"]
