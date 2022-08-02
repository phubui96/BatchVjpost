FROM centos:centos7
RUN yum update -y && \
    yum install -y epel-release && \
    yum upgrade -y 

RUN yum remove php-*

RUN yum install -y http://rpms.famillecollet.com/enterprise/remi-release-7.rpm && \
    yum install -y yum-utils && \
    yum-config-manager --enable remi-php80

RUN yum -y install php-fpm php-gd php-gmp php-mbstring php-mcrypt php-pdo php-pear-MDB2-Driver-mysqli php-pecl-memcached php-pecl-msgpack php-xml php-devel php-json php-xmlrpc php-zip libaio systemtap-sdt-devel cronie

RUN yum install -y nginx
RUN cp /etc/php-fpm.d/www.conf /etc/php-fpm.d/www.original
ADD /app/www.conf /etc/php-fpm.d/

RUN systemctl enable php-fpm.service

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/tmp --version=2.3.10 && \
    mv /tmp/composer.phar /usr/local/bin/composer && \
    ln -s /usr/local/bin/composer /bin


WORKDIR /home/batch

RUN cp /etc/nginx/nginx.conf /etc/nginx/nginx.original 
ADD /app/nginx.conf /etc/nginx/nginx.conf
ADD /app/conf.d/default.conf /etc/nginx/conf.d/default.conf

RUN systemctl enable nginx
