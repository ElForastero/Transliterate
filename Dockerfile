FROM php:8.2

RUN apt-get update && \
    apt-get install -y git zip unzip libicu-dev && \
    docker-php-ext-configure intl && \
    docker-php-ext-install intl && \
    php -r "readfile('http://getcomposer.org/installer');" | php -- --install-dir=/usr/bin/ --filename=composer && \
    apt-get -y autoremove && \
    apt-get clean && \
    rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*
