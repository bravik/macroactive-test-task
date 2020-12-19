FROM php:7.4-fpm-alpine

RUN apk --update add --no-cache $PHPIZE_DEPS \
        zip \
        sqlite \
        && docker-php-ext-install  mysqli pdo_mysql  \
        && rm -rf /var/cache/apk/*

# Composer
RUN curl -sS https://getcomposer.org/installer | tee composer-setup.php \
        && php composer-setup.php && rm composer-setup.php* \
        && chmod +x composer.phar && mv composer.phar /usr/bin/composer

# Code Sniffer
RUN curl -OL https://squizlabs.github.io/PHP_CodeSniffer/phpcs.phar && \
    mv phpcs.phar /usr/bin/phpcs && \
    chmod +x /usr/bin/phpcs

WORKDIR /app