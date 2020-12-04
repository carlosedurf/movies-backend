FROM wyveo/nginx-php-fpm:php74
WORKDIR /usr/share/nginx/
RUN rm -rf /usr/share/ngix/html
COPY . /usr/share/nginx
RUN chmod 775 -R /usr/share/nginx/storage/*
RUN ln -s public html
