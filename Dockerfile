FROM alpine:3.8

MAINTAINER maaanandsheela@protonmail.com

COPY ./ /var/www/html/
COPY entrypoint.sh /opt/entrypoint.sh

RUN apk --update add \
    curl php-apache2 php-cli php-json php-mbstring php-phar php-openssl && \
    rm -f /var/cache/apk/* && \
    chmod +x /opt/entrypoint.sh && \
    curl -sS https://getcomposer.org/installer | php -- \
    --install-dir=/usr/local/bin --filename=composer && \
    mkdir -p /var/www/html/ && chown -R apache:apache /var/www/html

COPY configs/httpd.conf /etc/apache2/httpd.conf
COPY configs/app.conf /etc/apache2/sites/
COPY configs/php.ini /etc/php7/php.ini

EXPOSE 80

WORKDIR /var/www/html/

ENTRYPOINT [ "/opt/entrypoint.sh" ]
