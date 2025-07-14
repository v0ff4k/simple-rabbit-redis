FROM php:7.4-cli-alpine

WORKDIR /app

# Установка зависимостей
RUN apk add --no-cache curl && \
    curl -sS https://getcomposer.org/installer  | php -- --install-dir=/usr/local/bin --filename=composer

COPY . .
RUN composer require php-amqplib/php-amqplib

# Запуск consumer и веб-сервера
CMD ["sh", "-c", "php consumer.php & php -S 0.0.0.0:8000 producer.php"]