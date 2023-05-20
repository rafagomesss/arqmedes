# Imagem base do PHP com Apache
FROM php:8.2.4-apache

# Atualiza a lista de pacotes e instala as dependências necessárias
RUN apt-get update \
    && apt-get install -y \
        libmcrypt-dev \
        openssl \
        libzip-dev \
        zip \
        unzip \
        libonig-dev \
        libxml2-dev \
        libpq-dev \
        libpng-dev\
    && docker-php-ext-install \
        pdo_mysql \
        mbstring \
        zip \
        exif \
        pcntl \
        bcmath \
        opcache \
    && pecl install redis libsodium \
    && docker-php-ext-enable sodium \
    && rm -rf /var/lib/apt/lists/*

# Instalar nano e vi
RUN apt-get update && apt-get install -y nano

# Habilita o módulo rewrite do Apache
RUN a2enmod rewrite

# Configure as extensões do PHP
RUN docker-php-ext-install \
    pdo_mysql \
    zip \
    mbstring \
    gd \
    iconv \
    opcache \
    exif \
    bcmath \
    pcntl

# Copia o código do projeto para o diretório de trabalho
COPY . /var/www/html/arqmedes/

# Define o diretório de trabalho
WORKDIR /var/www/html/arqmedes


# Copiar arquivo de configuração do Apache
COPY .docker/vhost.conf /etc/apache2/sites-available/000-default.conf

# Configure as permissões de pasta
RUN chown -R www-data:www-data /var/www/html/arqmedes \
    && chmod 755 /var/www/html/arqmedes

# Instala as dependências do Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer install --no-plugins --no-scripts --no-interaction --prefer-dist

# Remova informações sensíveis
RUN rm -rf .env

# Abra a porta 80 para o Apache
EXPOSE 80