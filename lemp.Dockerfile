FROM alpine:3.20

RUN apk update && apk add --no-cache \
    nginx \
    mysql mysql-client \
    php83-fpm \
    php83-mysqli \
    php83-pdo_mysql \
    php83-mbstring \
    php83-json \
    php83-session \
    php83-xml \
    php83-zip \
    php83-gd \
    php83-curl \
    php83-opcache \
    php83-intl \
    php83-bcmath \
    php83-pecl-imagick \
    php83-pecl-ssh2 \
    php83-dom \
    php83-exif \
    php83-fileinfo \
    php83-simplexml \
    php83-sockets \
    php83-zlib \
    php83-soap \
    php83-gmp \
    phpmyadmin && \
    # Создание групп и пользователей
    addgroup -S www-data || true && \
    addgroup -S mysql || true && \
    adduser -S -G www-data www-data && \
    # Настройка директорий
    mkdir -p \
    /run/nginx \
    /var/www/html/localhost/htdocs \
    /run/php \
    /run/mysqld \
    /var/lib/mysql \
    /var/log/mysql \
    /usr/share/webapps/phpmyadmin/tmp && \
    # Установка прав
    chown -R www-data:www-data /var/www /usr/share/webapps/phpmyadmin/tmp && \
    chown -R mysql:mysql /run/mysqld /var/lib/mysql /var/log/mysql && \
    chmod -R 775 /run/mysqld /var/lib/mysql /var/log/mysql && \
    chmod 755 /usr/share/webapps/phpmyadmin/tmp

COPY ./php/config/php-fpm.conf /etc/php83/php-fpm.conf
COPY ./mysql/config/my.cnf /etc/my.cnf.d/
COPY ./mysql/phpmyadmin/config.user.inc.php /etc/phpmyadmin/config.user.inc.php
COPY ./mysql/config/init.sh ./mysql/config/root-pass.sh /

RUN chmod +x /init.sh /root-pass.sh

EXPOSE 80 3306

CMD ["sh", "-c", "/init.sh & /root-pass.sh & nginx & php-fpm83"]