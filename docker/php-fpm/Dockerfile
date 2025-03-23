FROM php:8.3-fpm as base

# create user
RUN groupadd -g 1000 laravel
RUN useradd -u 1000 -ms /bin/bash -g laravel laravel

WORKDIR /var/project

RUN apt-get update

RUN apt-get install -y libpq-dev \
    && apt-get install -y zip \
    && apt-get install -y unzip \
    && apt-get install -y git \
    && apt-get install -y curl \
    && apt-get install -y nano \
    && apt-get install -y php-mysql \
    # Install extensions
    # && docker-php-ext-install pdo_pgsql \
    # && docker-php-ext-install pgsql \
    && docker-php-ext-install zip \
    # Enable extensions
    # && docker-php-ext-enable pdo_pgsql \
    && docker-php-ext-enable pdo_mysql \
    && docker-php-ext-enable pgsql \
    # install
    && apt-get -y install mbstring imagemagick php8.3-imagick php8.3-pcntl php8.3-gd php8.3-pgsql php8.3-mysql php8.3-sqlite nano php8.3-redis php-bcmath php8.3-zmq, pdo_pgsql pdo_mysql pdo \
    && apt-get clean; rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*

# RUN docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql

# Install MySQLi
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli

# Install PDO
RUN docker-php-ext-install pdo_mysql

#region Amqp
#RUN apt-get update && apt-get install -y librabbitmq-dev libssh-dev \
#    && docker-php-ext-install opcache bcmath sockets \
#    && pecl install amqp \
#    && docker-php-ext-enable amqp
#endregion

#COPY ../../../ /var/project

#RUN chown -R laravel:laravel \
#      /var/project/storage \
#      /var/project/bootstrap/cache

############################################################################################
FROM base as local

# Xdebug
RUN pecl install xdebug
RUN docker-php-ext-enable xdebug

COPY configs/local-php.ini $PHP_INI_DIR/php.ini

############################################################################################
FROM base as develop

COPY configs/development-php.ini $PHP_INI_DIR/php.ini

############################################################################################
FROM base as production

COPY configs/production-php.ini $PHP_INI_DIR/php.ini