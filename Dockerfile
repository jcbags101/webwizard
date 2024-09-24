FROM richarvey/nginx-php-fpm:3.1.6

# COPY . .

# # Image config
# ENV SKIP_COMPOSER 1
# ENV WEBROOT /var/www/html/public
# ENV PHP_ERRORS_STDERR 1
# ENV RUN_SCRIPTS 1
# ENV REAL_IP_HEADER 1
# ENV GIT_EMAIL jude@symph.co
# ENV GIT_NAME Jude Bags
# # ENV GIT_REPO github.com/jcbags101/webwizard.git

# # Laravel config
# ENV APP_ENV production
# ENV APP_DEBUG false
# ENV LOG_CHANNEL stderr

# # Allow composer to run as root
# ENV COMPOSER_ALLOW_SUPERUSER 1\

# ENV DOMAIN webwizard-e45c.onrender.com

# # Expose HTTP port
# EXPOSE 9191

# CMD ["/start.sh"]


# FROM richarvey/nginx-php-fpm:3.0.0
COPY . .
# Image config
ENV SKIP_COMPOSER 1
ENV WEBROOT /var/www/html/public
ENV PHP_ERRORS_STDERR 1
ENV RUN_SCRIPTS 1
ENV REAL_IP_HEADER 1
# Laravel config
ENV APP_ENV production
ENV APP_DEBUG false
ENV LOG_CHANNEL stderr
# Allow composer to run as root
ENV COMPOSER_ALLOW_SUPERUSER 1
CMD ["/start.sh"]