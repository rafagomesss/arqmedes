# Imagem base do PHP com Apache
FROM php:8.2.4-apache

ENV WORKDIR=/var/www/html/arqmedes

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
        libpng-dev \
        libjpeg-dev \
        libxslt1-dev \
        libsodium-dev \
        nano \
    && pecl install xdebug redis libsodium \
    && docker-php-ext-install \
        -j$(nproc) gd \
        iconv \
        pcntl \
        bcmath \
        xml \
        soap \
        mbstring \
        pdo \
        pdo_mysql \
        pdo_pgsql \
        mysqli \
        zip \
        opcache \
        exif \
        sodium \
    && docker-php-ext-enable xdebug \
    && rm -rf /var/lib/apt/lists/*

# Atualiza a lista de pacotes e instala as dependências necessárias
# RUN apt-get update \
#     && apt-get install -y \
#         libmcrypt-dev \
#         openssl \
#         libzip-dev \
#         zip \
#         unzip \
#         libonig-dev \
#         libxml2-dev \
#         libpq-dev \
#         libpng-dev \
#         nano \
#     && pecl install redis libsodium \
#     && docker-php-ext-enable sodium pdo_mysql \
#     && rm -rf /var/lib/apt/lists/*

# # Instalar nano
# RUN apt-get update && apt-get install -y nano

# RUN docker-php-ext-install \
#   -j$(nproc) gd \
#   iconv \
#   pcntl \
#   bcmath \
#   xml \
#   soap \
#   mbstring \
#   pdo \
#   pdo_mysql \
#   pdo_pgsql \
#   mysqli \
#   zip \
#   opcache \
#   intl \
#   xsl \
#   exif \
#   soap

# Habilita o módulo rewrite do Apache
RUN a2enmod rewrite

# Copia o código do projeto para o diretório de trabalho
COPY . ${WORKDIR}

# Define o diretório de trabalho
WORKDIR ${WORKDIR}


# Copiar arquivo de configuração do Apache
COPY ./docker/apache/config/vhost.conf /etc/apache2/sites-available/000-default.conf

# Configure as permissões de pasta
RUN chown -R www-data:www-data ${WORKDIR} \
    && chmod 755 ${WORKDIR}

# Instala as dependências do Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer install --no-plugins --no-scripts --no-interaction --prefer-dist

# Definir variáveis de ambiente do MySQL
ENV MYSQL_ROOT_PASSWORD root

# Abra a porta 80 para o Apache
EXPOSE 80

# Comando de inicialização
CMD ["apache2-foreground"]