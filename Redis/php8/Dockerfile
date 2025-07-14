FROM php:8.1-cli-alpine

WORKDIR /app

# Установка зависимостей
RUN apk add --no-cache curl && \
    curl -sS https://getcomposer.org/installer  | php -- --install-dir=/usr/local/bin --filename=composer

COPY . .
RUN composer require predis/predis

CMD ["sh", "-c", "php consumer.php & php -S 0.0.0.0:8001 producer.php"]