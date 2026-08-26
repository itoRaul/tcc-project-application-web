FROM php:8.4-cli-alpine

# Instala dependências do sistema e extensões do PHP necessárias para o PostgreSQL
RUN apk add --no-cache \
    postgresql-dev \
    bash \
    git \
    unzip \
    && docker-php-ext-install pdo pdo_pgsql

# Instala o Composer globalmente
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Define o diretório de trabalho interno
WORKDIR /var/www/html

# Expõe a porta padrão do servidor de desenvolvimento do Laravel
EXPOSE 8000

# Executa o servidor de desenvolvimento do Laravel apontando para todas as interfaces de rede
CMD php artisan serve --host=0.0.0.0 --port=8000