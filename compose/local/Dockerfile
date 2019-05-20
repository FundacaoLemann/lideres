FROM hacklab/wordpress:v5.1.1-php7.2

LABEL mantainer "hacklab/ <contato@hacklab.com.br>"

USER www-data

# Insert our data and dependencies
COPY ["compose/entrypoint-extra", "/docker-entrypoint-extra"]
COPY ["composer.json", "/var/www/html/composer.json"]
COPY ["languages", "/var/www/html/languages"]
RUN mkdir vendor
RUN composer install

COPY "compose/cron.sh" /cron.sh
# Fix file permissions
USER root
