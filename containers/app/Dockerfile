FROM registry.access.redhat.com/ubi8/ubi:8.4-209

RUN dnf install -y sudo procps

RUN dnf module install -y php:7.4 \
  && dnf install https://dl.fedoraproject.org/pub/epel/epel-release-latest-8.noarch.rpm -y \
  && dnf install -y \
      gd \
      xz \
      zip \
      unzip \
      git \
      net-tools \
      zlib-devel \
      libzip-devel \
      freetype-devel \
      libjpeg \
      libjpeg-turbo-devel \
      libmcrypt \
      libmcrypt-devel \
      libaio \
      php-pdo \
      php-mysqlnd \
      php-opcache \
      php-json \
      php-soap \
      nginx \
      java-1.8.0-openjdk

# composer install
RUN curl \
    --silent \
    --fail \
    --location \
    --retry 3 \
    --output /tmp/installer.php \
    --url https://getcomposer.org/installer && \
    php /tmp/installer.php --no-ansi --install-dir=/usr/bin --filename=composer && \
    rm -f /tmp/installer.php

# For Local
RUN curl https://raw.githubusercontent.com/vishnubob/wait-for-it/master/wait-for-it.sh --output "/usr/local/bin/wait-for-it.sh" \
    && chmod +x /usr/local/bin/wait-for-it.sh

RUN useradd -m batch

COPY ./nginx/nginx.conf /etc/nginx/nginx.conf
COPY ./nginx/conf.d /etc/nginx/conf.d
COPY ./php-fpm/php-fpm.d /etc/php-fpm.d
COPY ./php-fpm/php-fpm.conf /etc/php-fpm.conf

RUN dnf install -y httpd-tools

# # PHP
RUN systemctl enable nginx.service

# # nginx -g "daemon off;"
# # php-fpm -F

#USER batch
RUN mkdir -p /home/batch/logs/php-fpm/
RUN mkdir -p /home/batch/logs/nginx/

#WORKDIR /var/www/src

#CMD ["/sbin/init"]
EXPOSE 9000