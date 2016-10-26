# Get PHP base image and install extensions
FROM php:7.0.11-apache
RUN usermod -u 1000 www-data && groupmod -g 1000 www-data

RUN ln -sf /config/apache2.conf /etc/apache2/apache2.conf
RUN ln -sf /config/php.ini /usr/local/etc/php/php.ini

RUN docker-php-ext-install pdo_mysql

# Update repos / Install / Remove repos
RUN apt-get update && apt-get install -y git unzip zlib1g-dev \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libmcrypt-dev \
        libpng12-dev \
        libicu-dev g++ \
    && apt-get clean && apt-get autoremove \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

RUN docker-php-ext-install -j$(nproc) iconv mcrypt \
    && docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
    && docker-php-ext-install -j$(nproc) gd \
    && docker-php-ext-configure intl \
    && docker-php-ext-install intl

RUN docker-php-ext-install zip
# Install Composer and make it available in the PATH
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin/ --filename=composer

RUN chown www-data:www-data /var/www
USER www-data
RUN git config --global user.name "CWP Dev"
RUN git config --global user.email "dev@cwp.nu"
USER root
COPY docker/.ssh /var/www/.ssh
RUN ssh-keyscan github.com >> /var/www/.ssh/known_hosts
RUN chown www-data:www-data /var/www/.ssh -R && chmod 400 /var/www/.ssh/id_rsa

COPY docker/apache2.conf /config/apache2.conf
COPY docker/php.ini /config/php.ini

# Enable MOD_REWRITE and restart apache
RUN a2enmod rewrite && a2enmod ssl && service apache2 restart
