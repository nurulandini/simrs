FROM yiisoftware/yii2-php:8.1-apache

# Change web server config
# COPY docker/nginx/nginx.conf /etc/nginx/conf.d/default.conf
COPY docker/httpd/httpd.conf /etc/apache2/apache2.conf
COPY docker/httpd/vhost.conf /etc/apache2/sites-available/000-default.conf

# change PHP config
COPY docker/php/php.ini /usr/local/etc/php/conf.d/base.ini

# enable yii queue service
RUN apt-get update && apt-get install -y --force-yes supervisor --no-install-recommends && apt-get clean && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

COPY docker/supervisord/supervisord.conf /etc/supervisor/supervisord.conf

COPY docker/supervisord/conf.d/apache2.conf /etc/supervisor/conf.d/apache2.conf

CMD ["supervisord", "-c", "/etc/supervisor/supervisord.conf"]