FROM dunglas/frankenphp

RUN install-php-extensions @composer apcu curl pcntl pdo_mysql pdo_pgsql pdo_sqlite redis gd zip bcmath intl opcache xdebug

# Change the UID of the www-data user to match the host's UID
RUN usermod -u 1000 www-data

# SInce we run Caddy as www-data, give the folders the correct permissions
RUN chown -R www-data:www-data /data/caddy /config/caddy

WORKDIR /app