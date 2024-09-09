FROM richarvey/nginx-php-fpm:latest

COPY . .

# Image config
ENV SKIP_COMPOSER 1
ENV WEBROOT /var/www/html/public
ENV PHP_ERRORS_STDERR 1
ENV RUN_SCRIPTS 1
ENV REAL_IP_HEADER 1
ENV GIT_EMAIL jude@symph.co
ENV GIT_NAME Jude Bags
ENV GIT_USERNAME jcbags101
ENV GIT_REPO https://github.com/jcbags101/webwizard

# Laravel config
ENV APP_ENV production
ENV APP_DEBUG false
ENV LOG_CHANNEL stderr

# Allow composer to run as root
ENV COMPOSER_ALLOW_SUPERUSER 1

# Expose HTTP port
EXPOSE 9191

CMD ["/start.sh"]
