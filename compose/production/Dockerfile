FROM hacklab/wordpress:v5.1.1-php7.2

LABEL mantainer "hacklab/ <contato@hacklab.com.br>"

ARG composer='--no-dev'
USER www-data

# Insert our data and dependencies
COPY ["compose/entrypoint-extra", "/docker-entrypoint-extra"]
COPY ["compose/production/wp-config.d/", "/var/www/html/wp-config.d"]
COPY ["composer.json", "/var/www/html/composer.json"]
RUN mkdir vendor
RUN composer install -v $composer
#COPY ["wp-content", "/var/www/html/wp-content"]
COPY ["plugins", "/var/www/html/plugins"]
COPY ["themes", "/var/www/html/wp-content/themes"]
COPY ["importer", "/importer"]
COPY ["languages", "/var/www/html/languages"]

COPY "compose/cron.sh" /cron.sh

# Fix file permissions
USER root
RUN chown -R www-data: wp-content
