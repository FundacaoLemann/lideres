FROM hacklab/wordpress:v4.9.7-php7.2

LABEL mantainer "hacklab/ <contato@hacklab.com.br>"

USER www-data

# Insert our data and dependencies
COPY ["compose/entrypoint-extra", "/docker-entrypoint-extra"]
COPY ["composer.json", "/var/www/html/composer.json"]
COPY ["languages", "/var/www/html/languages"]
RUN mkdir vendor
RUN composer install

# Fix file permissions
USER root
