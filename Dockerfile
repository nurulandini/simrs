FROM yiisoftware/yii2-php:8.1-apache

# Change web server config
COPY conf/apache.conf /etc/apache2/apache2.conf
COPY conf/vhost.conf /etc/apache2/sites-available/000-default.conf

# change PHP config
COPY conf/php.ini /usr/local/etc/php/conf.d/base.ini