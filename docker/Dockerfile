# Stage 1: build vendor directory
FROM registry.gitlab.com/artemtech/php:8.1-composer2 AS vendor

COPY composer.json composer.json
COPY composer.lock composer.lock

RUN composer install --prefer-dist --no-scripts --no-autoloader

# Stage 2: Build all app
FROM registry.gitlab.com/artemtech/php:8.1-nginx-composer2

COPY --from=vendor --chown=www-data:www-data /var/www/html/vendor /var/www/html/vendor

COPY ./docker/supervisor.conf /etc/supervisor.d/laravel.conf
COPY ./docker/local.ini /usr/local/etc/php/conf.d/local.ini
COPY ./docker/nginx.conf /etc/nginx/http.d/default.conf
COPY ./docker/entrypoint.sh /
COPY --chown=www-data:www-data . /var/www/html

EXPOSE 80

ENTRYPOINT ["sh", "/entrypoint.sh"]
