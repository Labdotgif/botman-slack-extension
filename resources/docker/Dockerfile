FROM php:7.2

ENV XDEBUG_VERSION 2.6.0

RUN additionalPackages=" \
        apt-transport-https \
        git \
        openssh-client \
    " \
    buildDeps=" \
        libbz2-dev \
        libicu-dev \
        libssl-dev \
        libxml2-dev \
        zlib1g-dev \
    " \
    && runDeps=" \
        libicu57 \
    " \
    && phpModules=" \
        bcmath \
        intl \
        opcache \
        zip \
        xdebug \
    " \
    && echo "deb http://httpredir.debian.org/debian jessie contrib non-free" > /etc/apt/sources.list.d/additional.list \
    && apt-get update \
    && apt-get install -y --no-install-recommends $additionalPackages $buildDeps $runDeps \
    && docker-php-source extract \
    && cd /usr/src/php/ext/ \
    && curl -L http://xdebug.org/files/xdebug-$XDEBUG_VERSION.tgz | tar -zxf - \
    && mv xdebug-$XDEBUG_VERSION xdebug \
    && docker-php-ext-install $phpModules \
    && printf "\n" \
    && for ext in $phpModules; do \
           rm -f /usr/local/etc/php/conf.d/docker-php-ext-$ext.ini; \
       done \
    && docker-php-source delete \
    && apt-get purge -y --auto-remove -o APT::AutoRemove::RecommendsImportant=false -o APT::AutoRemove::SuggestsImportant=false $buildDeps \
    && apt-get clean && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

# Install composer and put binary into $PATH
RUN curl -sS https://getcomposer.org/installer | php \
    && mv composer.phar /usr/local/bin/ \
    && ln -s /usr/local/bin/composer.phar /usr/local/bin/composer

RUN docker-php-ext-enable zip bcmath intl opcache

CMD ["php", "-a"]
