FROM php:7.1-apache
RUN apt-get update && apt-get install -y \
    zlib1g-dev \
    wget \
    mc \
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
