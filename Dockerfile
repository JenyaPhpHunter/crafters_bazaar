# Використовуємо офіційний образ PHP з Apache
FROM php:8.1-apache

# Встановлюємо залежності та необхідні розширення PHP
RUN apt-get update && apt-get install -y \
    libpng-dev libjpeg-dev libfreetype6-dev \
    zip unzip git curl libonig-dev libxml2-dev libxslt-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql intl xsl

# Встановлюємо Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Включаємо модуль rewrite для Apache
RUN a2enmod rewrite

# Копіюємо проект в контейнер
COPY . /var/www/html

# Встановлюємо залежності проекту
RUN composer install --no-dev --optimize-autoloader

# Налаштовуємо права доступу для необхідних директорій
RUN mkdir -p /var/www/html/storage/logs /var/www/html/storage/framework/sessions /var/www/html/storage/framework/views /var/www/html/bootstrap/cache \
    && chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Копіюємо конфігураційний файл Apache
COPY ./docker/apache/apache.conf /etc/apache2/sites-available/000-default.conf

# Встановлюємо робочу директорію
WORKDIR /var/www/html

# Відкриваємо порт 80 для Apache
EXPOSE 80

# Запускаємо Apache
CMD ["apache2-foreground"]
