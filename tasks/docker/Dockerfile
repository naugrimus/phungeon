FROM debian:12.11

#initial install
RUN apt-get update && DEBIAN_FRONTEND=nonointeractive apt-get install --no-install-recommends -y \
        gnupg \
        apt-transport-https \
        ca-certificates \
        gnupg2 \
        lsb-release \
        software-properties-common \
     && rm -rf /var/lib/apt/lists/*_

# install base system
RUN apt-get update && DEBIAN_FRONTEND=noninteractive apt-get install --no-install-recommends -y \
        acl \
        aptitude \
        curl \
        git \
        libyaml-dev \
        vim \
        wget \
        sudo \
        build-essential \
        libncurses-dev \
        software-properties-common \
        && curl -fsSL https://packages.sury.org/php/apt.gpg | apt-key add - \
        && echo "deb https://packages.sury.org/php/ $(lsb_release -sc) main" > /etc/apt/sources.list.d/sury-php.list \
     && rm -rf /var/lib/apt/lists/*_

ENV PHP_VERSION 8.2
RUN curl -s -L https://packages.sury.org/php/apt.gpg | apt-key add - \
    && echo "deb https://packages.sury.org/php/ $(lsb_release -sc) main" > /etc/apt/sources.list.d/sury_php.list \
    && apt-get update && DEBIAN_FRONTEND=noninteractive apt-get install --no-install-recommends -y \
        php${PHP_VERSION}-common \
        php${PHP_VERSION}-cli \
        php${PHP_VERSION}-dev \
        php${PHP_VERSION}-fpm \
        php${PHP_VERSION}-odbc \
        php${PHP_VERSION}-mysql \
        php${PHP_VERSION}-xmlrpc \
        php${PHP_VERSION}-uuid \
        php${PHP_VERSION}-bcmath \
        php${PHP_VERSION}-opcache \
        php${PHP_VERSION}-mbstring \
    && rm -rf /var/lib/apt/lists/*


RUN mkdir -p /run/php



COPY php-fpm/php-fpm.conf /etc/php/${PHP_VERSION}/fpm/php-fpm.conf
COPY php-fpm/php.ini /etc/php/${PHP_VERSION}/fpm/php.ini
COPY php-fpm/php.ini /etc/php/${PHP_VERSION}/cli/php.ini

RUN update-alternatives --set php /usr/bin/php${PHP_VERSION}

ENV COMPOSER_VERSION 2.8.9
RUN curl -L -s -o /usr/local/bin/composer https://getcomposer.org/download/$COMPOSER_VERSION/composer.phar \
    && chmod a+x /usr/local/bin/composer


# Setup entry script
COPY docker-entrypoint.sh /usr/local/bin
RUN chmod a+x /usr/local/bin/docker-entrypoint.sh
RUN chmod a+rw /etc/passwd && chmod a+rw /etc/group
RUN echo "niels ALL=(ALL:ALL) NOPASSWD: ALL" > /etc/sudoers.d/nopwsudo


ENTRYPOINT ["docker-entrypoint.sh"]

WORKDIR /app
