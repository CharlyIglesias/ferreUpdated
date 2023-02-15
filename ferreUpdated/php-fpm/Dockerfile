#FROM php:fpm-alpine
FROM php:8.1-fpm-alpine3.16

COPY wait-for-it.sh /usr/bin/wait-for-it
RUN chmod +x /usr/bin/wait-for-it
RUN apk --update --no-cache add git
RUN docker-php-ext-install pdo_mysql
RUN apk add --no-cache \
      libzip-dev \
      zip \
    && docker-php-ext-install zip
#RUN docker-php-ext-configure gd && docker-php-ext-install gd
RUN apk add --no-cache libpng libpng-dev && docker-php-ext-install gd && apk del libpng-dev
RUN apk update && apk add bash
CMD echo Installed bash
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
WORKDIR /var/www
RUN chown -R www-data:www-data /var/www
RUN chmod -R 755 /var/www
CMD composer install ; php bin/console cache:clear ; php bin/console cache:warmup --env=dev; echo "RUNNING SYNC!!!!!!!!!!!!1"; wait-for-it database:3306 -- php bin/console doctrine:migrations:sync-metadata-storage; wait-for-it database:3306 -- php bin/console doctrine:migrations:diff --no-interaction; wait-for-it database:3306 -- php bin/console doctrine:migrations:execute --up 'DoctrineMigrations\\Version20210415125400' --no-interaction ; wait-for-it database:3306 -- php bin/console doctrine:migrations:migrate --no-interaction; php-fpm
RUN printf '[PHP]\ndate.timezone = "America/Mexico_City"\n' > /usr/local/etc/php/conf.d/tzone.ini
EXPOSE 9000
