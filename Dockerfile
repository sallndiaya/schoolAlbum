# Image officielle PHP avec Apache
FROM php:8.1-apache

# Copier le contenu du projet dans le conteneur
COPY . /var/www/html/

# Donner les permissions nécessaires
RUN chown -R www-data:www-data /var/www/html/ \
    && chmod -R 755 /var/www/html/

# Exposer le port 80
EXPOSE 80
