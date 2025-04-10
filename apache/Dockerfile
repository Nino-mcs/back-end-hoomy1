# Utilisation de l'image officielle PHP avec Apache
FROM php:8.4-apache

# Installation des dépendances nécessaires
RUN apt-get update && apt-get install -y \
  git \
  unzip \
  wget \
  libpng-dev \
  libjpeg-dev \
  libfreetype6-dev \
  libzip-dev \
  libicu-dev \
  curl \
  && docker-php-ext-configure gd --with-freetype --with-jpeg \
  && docker-php-ext-install gd zip intl \
  && apt-get clean && rm -rf /var/lib/apt/lists/*

# Installation de Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Activation des extensions PHP nécessaires
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Configuration d'Apache pour utiliser /var/www/html/public comme racine du document
RUN sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf

# Activation des modules Apache nécessaires
RUN a2enmod rewrite
RUN a2enmod proxy proxy_http

# Configuration d'Apache pour utiliser le nom de domaine local
RUN echo 'ServerName localhost' >> /etc/apache2/apache2.conf

# Configuration d'Apache pour conserver l'hôte original dans les redirections
RUN echo 'ProxyPreserveHost On' >> /etc/apache2/apache2.conf

# Installation de Symfony CLI
RUN wget https://get.symfony.com/cli/installer -O - | bash \
  && mv /root/.symfony*/bin/symfony /usr/local/bin/symfony

# Copie de la configuration PHP personnalisée
COPY custom-php.ini /usr/local/etc/php/conf.d/

# Installation de Xdebug
RUN pecl install xdebug && docker-php-ext-enable xdebug

# Installation directe de Node.js 22.x
RUN apt-get update && apt-get install -y ca-certificates gnupg
RUN mkdir -p /etc/apt/keyrings
RUN curl -fsSL https://deb.nodesource.com/gpgkey/nodesource-repo.gpg.key | gpg --dearmor -o /etc/apt/keyrings/nodesource.gpg
RUN echo "deb [signed-by=/etc/apt/keyrings/nodesource.gpg] https://deb.nodesource.com/node_22.x nodistro main" | tee /etc/apt/sources.list.d/nodesource.list
RUN apt-get update && apt-get install -y nodejs
RUN npm install -g npm@latest

# Configuration des permissions pour le répertoire web
RUN chown -R www-data:www-data /var/www/html

# Exposition du port 80
EXPOSE 80

# Commande de démarrage d'Apache
CMD ["apache2-foreground"]



