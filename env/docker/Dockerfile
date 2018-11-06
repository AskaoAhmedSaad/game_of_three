FROM php:7.1-fpm
ENV DEBIAN_FRONTEND noninteractive
RUN apt-get update && apt-get install -y \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libmcrypt-dev \
        libpng12-dev \
    && docker-php-ext-install -j$(nproc) iconv mcrypt \
    && docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
    && docker-php-ext-install -j$(nproc) gd
	
RUN  apt-get update \
	&& docker-php-ext-install pdo pdo_mysql \
	&& docker-php-ext-install zip \
	&& curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
    
RUN  echo 'export PATH="$PATH:$HOME/.composer/vendor/bin"' >> ~/.bashrc

RUN apt-get update && apt-get install -y libc-client-dev libkrb5-dev && rm -r /var/lib/apt/lists/*


RUN apt-get update && apt-get install -y zlib1g-dev libicu-dev g++

RUN docker-php-ext-configure intl
RUN docker-php-ext-install intl

RUN apt-get install -y git

RUN curl -LsS https://codeception.com/codecept.phar -o /usr/local/bin/codecept
RUN chmod a+x /usr/local/bin/codecept

WORKDIR /code

RUN chown -R www-data:www-data /code

RUN usermod -u 1000 www-data
RUN groupmod -g 1000 www-data

USER www-data


