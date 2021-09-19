FROM ubuntu:latest

RUN apt update
# タイムゾーンの設定
RUN apt install -y tzdata \
&& ln -sf /usr/share/zoneinfo/Asia/Tokyo /etc/localtime
RUN apt install -y vim
RUN apt install -y mysql-server mysql-client
RUN apt install -y expect
RUN apt install -y sudo

RUN apt update
RUN apt install -y apache2
RUN apt install -y curl
# MySQLを外部から接続可能にする
# \s*はスペースが0個以上
RUN sed -i -e"s/^bind-address\s*=\s*127.0.0.1/bind-address = 0.0.0.0/" /etc/mysql/mysql.conf.d/mysqld.cnf

RUN apt-get install -y software-properties-common
RUN add-apt-repository ppa:ondrej/php

RUN apt update

RUN apt install -y php8.0 php8.0-intl php8.0-mysql php8.0-sqlite3 php8.0-gd php8.0-dom
RUN apt install -y curl php-cli php-mbstring git unzip

RUN php -r "copy ( 'https://getcomposer.org/installer', 'composer-setup.php' ) ;";
RUN php composer-setup.php --install-dir=/usr/local/bin --filename=composer;
# 上手く行かないかも
RUN composer create-project laravel/laravel --prefer-dist /var/www/canvas
# 上手く行かないかも
RUN sed -i 's/html/canvas\/public/' /etc/apache2/sites-available/000-default.conf
# 上手く行かないかも
RUN chmod -R 777 /var/www/canvas

COPY launch.sh /root/
COPY init_mysql.sql /root/

EXPOSE 80
EXPOSE 3306

ENTRYPOINT [ "/root/launch.sh" ]