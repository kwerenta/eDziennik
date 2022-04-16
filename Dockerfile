FROM php:7.4-cli-alpine
RUN docker-php-ext-install -j "$(nproc)" pdo_mysql mysqli
EXPOSE 80
CMD ["php", "-S", "0.0.0.0:80", "-t", "/app"]
