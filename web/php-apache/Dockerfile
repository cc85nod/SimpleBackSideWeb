# Creating multiple images from a single Dockerfile
FROM php:7.3-apache
LABEL maintainer="JERRY"
RUN apt-get -o Acquire::Check-Valid-Until=false update \
    && apt-get install -y \
    git \ 
    unzip \
    && docker-php-ext-install \
    pdo_mysql \
    mysqli \
    && a2enmod rewrite
COPY --from=composer:1.9.0 /usr/bin/composer /usr/bin/composer

#Build
# 1. docker build -t my-apache2 .
# 2. docker run -dit --name my-running-app -p 8080:80 my-apache2