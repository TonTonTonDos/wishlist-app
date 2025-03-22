FROM php:8.3-fpm

# Установка зависимостей
RUN apt-get update && apt-get install -y \
    libpq-dev \
    libzip-dev \
    unzip \
    git \
    dos2unix \
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

# Исправление окончаний строк для всех файлов скриптов
RUN find /var/www -type f -name "*.sh" -exec dos2unix {} \; \
    && find /var/www -type f -name "yii" -exec dos2unix {} \; \
    && chmod +x /var/www/yii

# Установка прав доступа
RUN chown -R www-data:www-data /var/www

# Установка зависимостей Composer
RUN cd /var/www && composer install --no-interaction

# Генерация автозагрузчика
RUN cd /var/www && composer dump-autoload --optimize

CMD ["php-fpm"]