FROM php:8.3-fpm

# Установка зависимостей
RUN apt-get update && apt-get install -y \
    libpq-dev \
    libzip-dev \
    unzip \
    git \
    && docker-php-ext-install \
    pdo \
    pdo_pgsql \
    pgsql \
    zip

# Установка Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Установка рабочей директории
WORKDIR /var/www

# Копирование исходного кода приложения
COPY ./src /var/www

# Установка прав доступа
RUN chown -R www-data:www-data /var/www

# Установка зависимостей Composer
RUN composer install --no-interaction --no-scripts --no-autoloader

# Генерация автозагрузчика
RUN composer dump-autoload --optimize