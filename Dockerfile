# Dockerfile

# Utiliser l'image officielle de PHP-FPM comme base
FROM php:7.4-fpm

# Installer les dépendances système
RUN apt-get update && apt-get install -y \
    libzip-dev \
    libpng-dev \
    libjpeg-dev \
    libxml2-dev \
    libicu-dev \
    gnupg \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

## Vérifier que les dépendances système requises pour l'extension GD sont installées
#RUN dpkg -l | grep libjpeg-dev && dpkg -l | grep libpng-dev

# Installer les extensions PHP
RUN docker-php-ext-configure zip
RUN docker-php-ext-install -j$(nproc) zip
RUN docker-php-ext-install -j$(nproc) pdo_mysql opcache intl
RUN docker-php-ext-configure gd #--with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/
RUN docker-php-ext-install -j$(nproc) gd \
    && rm -rf /var/lib/php/*

# Installer Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Définir le répertoire de travail comme le répertoire racine de l'application Symfony
WORKDIR /var/www/symfony

# Copier le fichier composer.json et composer.lock dans le conteneur et installer les dépendances
COPY composer.json composer.lock ./
#RUN composer install --prefer-dist --optimize-autoloader
RUN composer install \
    --ignore-platform-reqs \
    --no-interaction \
    --no-plugins \
    --no-scripts \
    --prefer-dist \
    --quiet

RUN curl -sS https://dl.yarnpkg.com/debian/pubkey.gpg | apt-key add -
RUN echo "deb https://dl.yarnpkg.com/debian/ stable main" | tee /etc/apt/sources.list.d/yarn.list
RUN apt update
RUN yes | apt install yarn


# Copier tous les fichiers de l'application dans le conteneur
COPY . .

# Donner les autorisations d'exécution au script symfony-cmd
#RUN chmod +x symfony-cmd

# Exposer le port 9000 pour PHP-FPM
EXPOSE 9000

# Démarrer PHP-FPM
CMD ["php-fpm"]
