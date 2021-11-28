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

COPY launch.sh /root/
COPY init_mysql.sql /root/

EXPOSE 80
EXPOSE 3306

RUN ls /root
RUN chmod +x /root/launch.sh


ENTRYPOINT [ "/root/launch.sh" ]