FROM php:7.2-apache

ENV APACHE_DOCUMENT_ROOT /var/www/html/public
#ENV APP_ENV=prod

RUN a2enmod rewrite
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

RUN apt-get update && apt-get install -y \
    zlib1g-dev \
    wget \
    mc \
    pgp \
    iputils-ping \
    zip \
    libzip-dev \
    curl \
    git-core \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* \
    && docker-php-ext-configure zip --with-libzip \
    && docker-php-ext-install zip \
    && curl -sS https://getcomposer.org/installer \
    | php -- --install-dir=/usr/local/bin --filename=composer \
    && wget https://get.symfony.com/cli/installer -O - | bash \
    && mv /root/.symfony/bin/symfony /usr/local/bin/symfony \
    && git config --global user.name "Tomasz Paloc" \
    && git config --global user.email "tomasz.paloc@gmail.com"

COPY bin /var/www/html/bin
COPY config /var/www/html/config
COPY public /var/www/html/public
COPY src /var/www/html/src
COPY vendor /var/www/html/vendor
COPY symfony.lock /var/www/html/
COPY LICENSE /var/www/html/
COPY composer.json /var/www/html/
COPY composer.lock /var/www/html/
COPY .gitignore /var/www/html/
COPY .env /var/www/html/

RUN mkdir -p /var/www/html/var/ && chown www-data:www-data /var/www/html/var/

