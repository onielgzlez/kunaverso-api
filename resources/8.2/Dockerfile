FROM php:8.2-fpm-alpine

LABEL maintainer="Oniel Gonzalez"

ENV DEBIAN_FRONTEND noninteractive
ENV TZ=UTC

RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone
RUN apk add --no-cache --update libxml2-dev zip unzip zlib-dev libpng-dev libzip-dev linux-headers supervisor

# laravel packages
COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/

RUN install-php-extensions bcmath exif pdo_mysql gd soap zip redis @composer
RUN docker-php-ext-enable bcmath exif pdo_mysql soap zip gd redis
 
COPY supervisord.conf /etc/supervisor/conf.d/supervisord.conf
COPY php.ini /etc/php/8.2/cli/conf.d/99-php.ini

# Copy existing application directory contents
COPY . /var/www/html

# Copy existing application directory permissions
COPY --chown=www-data:www-data . /var/www/html
RUN mkdir -p /var/log/supervisor

WORKDIR /var/www/html

EXPOSE 9000

ENTRYPOINT ["supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]