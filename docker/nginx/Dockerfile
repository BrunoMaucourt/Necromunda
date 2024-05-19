FROM nginx:latest

COPY ./docker/nginx/default.conf /etc/nginx/conf.d/
RUN echo "upstream php-upstream { server php-fpm:9000; }" > /etc/nginx/conf.d/upstream.conf

RUN mkdir -p /var/www/project/public
COPY ./public /var/www/project/public

RUN chown -R www-data:www-data /var/www/project/public
RUN chmod -R 755 /var/www/project/public

RUN usermod -u 1000 www-data