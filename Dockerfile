FROM php:8.3-apache

WORKDIR /var/www/html

RUN apt-get update && apt-get install -y \
    libpq-dev \
    libzip-dev \
    git \
    unzip \
    curl \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    gnupg \
    lsb-release \
    dirmngr \
    && rm -rf /var/lib/apt/lists/*

# Descargar e instalar el controlador ODBC de Microsoft para SQL Server (msodbcsql17)
# Esto es necesario para PDO dblib/sqlsrv
# Se actualiza la forma de añadir la clave GPG para Debian 12 (Bookworm)
RUN curl -fsSL https://packages.microsoft.com/keys/microsoft.asc | gpg --dearmor > /usr/share/keyrings/microsoft.gpg \
    && curl -fsSL https://packages.microsoft.com/config/debian/12/prod.list > /etc/apt/sources.list.d/mssql-release.list \
    && echo "deb [signed-by=/usr/share/keyrings/microsoft.gpg] https://packages.microsoft.com/debian/12/prod bookworm main" > /etc/apt/sources.list.d/mssql-release.list \
    && apt-get update \
    && ACCEPT_EULA=Y apt-get install -y msodbcsql17 unixodbc-dev \
    && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install pdo pdo_mysql \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd \
    && docker-php-ext-install mysqli \
    && docker-php-ext-install zip

RUN pecl install pdo_sqlsrv \
    && docker-php-ext-enable pdo_sqlsrv

RUN pecl install sqlsrv \
    && docker-php-ext-enable sqlsrv

RUN a2enmod rewrite

# Copia todos los archivos de tu contexto de construcción (donde está el Dockerfile)
# al directorio de trabajo del contenedor (/var/www/html)
COPY . /var/www/html/

RUN rm -f /var/www/html/index.html

EXPOSE 80

CMD ["apache2-foreground"]
