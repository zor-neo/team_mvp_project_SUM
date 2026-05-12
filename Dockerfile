FROM php:8.3-apache

RUN apt-get update \
    && apt-get install -y --no-install-recommends \
        ca-certificates \
        libcurl4-openssl-dev \
        libpq-dev \
    && docker-php-ext-install \
        curl \
        opcache \
        pdo_pgsql \
        pgsql \
    && a2enmod headers rewrite \
    && rm -rf /var/lib/apt/lists/*

COPY docker/opcache.ini /usr/local/etc/php/conf.d/opcache-recommended.ini
COPY docker/uploads.ini /usr/local/etc/php/conf.d/uploads.ini
COPY docker/apache-security.conf /etc/apache2/conf-available/spring-wisdom-security.conf
COPY docker/start-apache.sh /usr/local/bin/start-apache

RUN a2enconf spring-wisdom-security \
    && chmod +x /usr/local/bin/start-apache

WORKDIR /var/www/html
COPY spring-wisdom-v1/ /var/www/html/

RUN chown -R www-data:www-data /var/www/html

EXPOSE 10000

CMD ["start-apache"]
