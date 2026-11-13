
FROM php:8.3-apache

RUN docker-php-ext-install mysqli \
    && a2enmod rewrite

COPY . /var/www/html/

# Store the public Aiven CA certificate outside the website's public directory.
COPY certs/ca.pem /usr/local/share/ca-certificates/aiven-ca.pem

RUN chown -R www-data:www-data /var/www/html \
    && find /var/www/html -type d -exec chmod 755 {} \; \
    && find /var/www/html -type f -exec chmod 644 {} \; \
    && chmod 644 /usr/local/share/ca-certificates/aiven-ca.pem

EXPOSE 80
