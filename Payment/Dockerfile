FROM php:8.1-apache

WORKDIR /var/www/html

# install the required packages, PHP extensions, and composer
RUN apt-get update && \
    apt-get install -y \
        git \
        unzip \
        libzip-dev \
        supervisor \
        autoconf \
        zlib1g-dev \
        libxml2-dev \
        libcurl4-openssl-dev \
        libssl-dev && \
    docker-php-ext-install pdo pdo_mysql sockets && \
    curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer && \
    pecl install grpc-1.57.0 protobuf && \
    docker-php-ext-enable grpc protobuf

# clean up
RUN apt-get purge -y --auto-remove \
    autoconf \
    zlib1g-dev \
    libxml2-dev \
    libcurl4-openssl-dev && \
    rm -rf /var/lib/apt/lists/*

RUN composer clear-cache

# install composer dependencies
COPY laravel-app/composer.json laravel-app/composer.lock ./

RUN composer install --no-scripts --no-autoloader

COPY laravel-app .

# run the autoloader
RUN composer dump-autoload

# copy the supervisor program for starting roadrunner's grpc workers
COPY supervisor/roadrunner.conf /etc/supervisor/conf.d

# copy the start script
COPY start.sh /usr/local/bin/start.sh

# set execute permissions
RUN chmod +x /usr/local/bin/start.sh

# run the start script
CMD ["start.sh"]