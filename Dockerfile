FROM php:8.2-apache

RUN a2enmod rewrite
 
# Install packages
RUN apt-get update && \
  apt-get install -y \
    curl \
    unzip \
    git \
    libicu-dev \
    && \
  apt-get clean -y && \
  rm -rf /var/cache/apt /var/lib/apt/lists/*
 
# Install PHP extensions
RUN docker-php-ext-install mysqli pdo pdo_mysql \
    && docker-php-ext-configure intl \
    && docker-php-ext-install intl

# Apache
COPY ./apache-config.conf /etc/apache2/sites-enabled/000-default.conf
 
# Install Composer
RUN curl -sS https://getcomposer.org/installer \
  | php -- --install-dir=/usr/bin --filename=composer
 
# Set workdir
WORKDIR /var/www/html