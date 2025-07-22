FROM php:8.2-fpm

# Arguments definidos no docker-compose.yml
ARG user=dime
ARG uid=1000

# Instala dependências do sistema
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libmagickwand-dev \
    libonig-dev \
    libxml2-dev \
    libpq-dev \
    libcurl3-dev \
    libfontconfig1 \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    libxrender1 \
    zip \
    zlib1g-dev \
    unzip \
  && pecl install imagick \
  && docker-php-ext-enable imagick

# Instala extensões PHP
RUN docker-php-ext-configure gd --with-jpeg=/usr/include/ --with-freetype=/usr/include/ \
    && docker-php-ext-install curl pgsql pdo_pgsql pdo_mysql mbstring exif pcntl bcmath gd

# Instala Composer globalmente
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Cria usuário e diretório home
RUN useradd -m -G www-data,root -u $uid -d /home/$user $user

# Cria pasta .composer com permissão correta
RUN mkdir -p /home/$user/.composer \
    && chown -R $user:$user /home/$user

# Dá permissão na pasta /var/www para o usuário
RUN chown -R $user:www-data /var/www

WORKDIR /var/www

USER $user
