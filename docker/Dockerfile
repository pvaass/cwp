# syntax=docker/dockerfile:experimental
FROM php:7.4-apache

RUN apt-get update && \
    apt-get install -y python git unzip curl libpng-dev libmcrypt-dev cron supervisor zlib1g-dev libzip-dev libxml2-dev libicu-dev libsodium-dev libpq-dev  \
    && apt-get clean && apt-get autoremove \
    && cd /tmp && curl "https://s3.amazonaws.com/aws-cli/awscli-bundle-1.16.188.zip" \
   -o "awscli-bundle.zip" && \
   unzip awscli-bundle.zip && \
   ./awscli-bundle/install -i /usr/local/aws -b /usr/local/bin/aws && \
   rm awscli-bundle.zip && rm -rf awscli-bundle \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

RUN usermod -u 1000 www-data && groupmod -g 1000 www-data

RUN ln -sf /config/apache2.conf /etc/apache2/apache2.conf
RUN ln -sf /config/php.ini /usr/local/etc/php/php.ini

RUN docker-php-ext-install gd zip pdo pdo_mysql sodium soap bcmath pcntl sockets intl
#RUN docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/

RUN docker-php-ext-install zip
# Install Composer and make it available in the PATH
RUN wget https://raw.githubusercontent.com/composer/getcomposer.org/76a7060ccb93902cd7576b67264ad91c8a2700e2/web/installer -O - -q | php -- --quiet
#RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin/ --filename=composer
RUN chown www-data:www-data /var/www
USER www-data
RUN git config --global user.name "CWP Dev"
RUN git config --global user.email "dev@cwp.nu"
USER root
#COPY .ssh /var/www/.ssh
#RUN ssh-keyscan github.com >> /var/www/.ssh/known_hosts
#RUN chown www-data:www-data /var/www/.ssh -R && chmod 400 /var/www/.ssh/id_rsa

RUN curl https://curl.se/ca/cacert.pem --insecure -o /etc/ssl/certs/cacert.pem
RUN mkdir /root/.ssh && ssh-keyscan github.com >> /root/.ssh/known_hosts
# Keep this '&&' or docker will cache the repository
ARG COMMIT_HA=master
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer
RUN --mount=type=ssh git clone git@github.com:pvaass/cwp.git . && git checkout $COMMIT_HA
RUN --mount=type=ssh COMPOSER_ALLOW_SUPERUSER=1 SYMFONY_ENV=prod /usr/local/bin/composer install --no-interaction

# Clear cache from composer install
RUN rm var/cache -rf

COPY apache2.conf /config/apache2.conf
COPY php.ini /config/php.ini

# Enable MOD_REWRITE and restart apache
RUN a2enmod rewrite && a2enmod ssl && service apache2 restart
