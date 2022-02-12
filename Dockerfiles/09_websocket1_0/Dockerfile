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

RUN apt update
RUN php -r "copy ( 'https://getcomposer.org/installer', 'composer-setup.php' ) ;";
RUN php composer-setup.php --install-dir=/usr/local/bin --filename=composer;

RUN apt update
# 上手く行かないかも(上手くいかないなら、起動後、もう一回たたく)
RUN composer create-project laravel/laravel --prefer-dist /var/www/canvas
RUN sed -i 's/html/canvas\/public/' /etc/apache2/sites-available/000-default.conf
# 上手く行かないかも(上手くいかないなら、起動後、もう一回たたく)
# RUN chmod -R 777 /var/www/canvas

COPY launch.sh /root/
COPY init_mysql.sql /root/

RUN apt update
# タイムゾーンの設定
RUN apt install -y tzdata \
&& ln -sf /usr/share/zoneinfo/Asia/Tokyo /etc/localtime
RUN apt install -y vim
RUN apt install -y build-essential
RUN apt install -y gdb
RUN apt install -y as31
RUN apt install -y nasm
RUN apt update
RUN apt install -y openjdk-11-jdk

RUN apt update

# curlをインストール
RUN apt install -y curl

# tomcatのインストール
RUN groupadd tomcat
RUN useradd tomcat -g tomcat
RUN mkdir /opt/tomcat
RUN curl -O https://downloads.apache.org/tomcat/tomcat-9/v9.0.56/bin/apache-tomcat-9.0.56.tar.gz
RUN tar xzvf apache-tomcat-9.0.56.tar.gz -C /opt/tomcat --strip-components=1
RUN chgrp -R tomcat /opt/tomcat
RUN chmod -R g+r /opt/tomcat/conf
RUN chmod g+x /opt/tomcat/conf
RUN chown -R tomcat /opt/tomcat/webapps/ /opt/tomcat/work/ /opt/tomcat/temp/ /opt/tomcat/logs/
COPY tomcat /etc/init.d/

ENTRYPOINT [ "/root/launch.sh" ]