FROM debian:bookworm-slim

LABEL description="Docker image to build Phalcon on Debian Bookworm" \
      maintainer="Serghei Iakovlev <serghei@phalconphp.com>" \
      vendor=Phalcon \
      name="com.phalconphp.images.build.bookworm-8.2"

ENV PATH=/root/composer/vendor/bin:/app/vendor/bin:/app/bin:/app:${PATH}

# Installing composer
COPY --from=composer /usr/bin/composer /usr/bin/composer

# Installing php and extentions
RUN set -eux \
    && apt-get update \
    && apt-get install --no-install-recommends -yq \
        mc nano git wget curl zip unzip htop re2c \
        php8.2-cli \
        php8.2-fpm \
        php8.2-dev \
        php8.2-common \
        php8.2-curl \
        php8.2-gettext \
        php8.2-intl \
        php8.2-mbstring \
        php8.2-mysqli \
        php8.2-opcache \
        php8.2-pdo_* \
        php8.2-pgsql \
        php8.2-shmop \
        php8.2-xml \
        php8.2-xml \
        php8.2-zip \
    && apt-get autoremove -y \
    && apt-get autoclean -y \
    && apt-get clean -y \
    && rm -rf /tmp/* /var/tmp/* \
    && find /var/cache/apt/archives /var/lib/apt/lists -not -name lock -type f -delete \
    && find /var/cache -type f -delete \
    && find /var/log -type f | while read f; do echo -n '' > ${f}; done

# Editing www.conf
RUN echo "#!/bin/sh\nexit 0" > /usr/sbin/policy-rc.d \
    && sed -i -e "s/^;clear_env = no$/clear_env = no/" /etc/php/8.2/fpm/pool.d/www.conf \
    && sed -i -e "/listen = .*/c\listen = 8000" /etc/php/8.2/fpm/pool.d/www.conf

WORKDIR /app

EXPOSE 8000

CMD ["php-fpm8.2", "--nodaemonize", "--fpm-config=/etc/php/8.2/fpm/pool.d/www.conf"]
