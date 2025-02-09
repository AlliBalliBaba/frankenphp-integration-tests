FROM frankenphp-custom

# install PHP extensions
RUN install-php-extensions @composer xhprof mysqli gmp xml apcu curl pcntl pdo_mysql pdo_pgsql pdo_sqlite redis gd zip bcmath intl opcache exif

# setup for profiling
RUN apt-get update && apt-get install -y git && apt-get install -y wrk
WORKDIR /flame
RUN git clone https://github.com/brendangregg/FlameGraph.git
RUN mkdir /profile && chmod 777 /profile && chmod -R www-data:www-data /flame

# adjust permissions
WORKDIR /app
# Change the UID of the www-data user to match the host's UID
RUN usermod -u 1000 www-data
# Since we run Caddy as www-data, give the folders the correct permissions
RUN chown -R www-data:www-data /data/caddy /config/caddy