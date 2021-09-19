FROM ubuntu:latest

RUN apt update
# タイムゾーンの設定
RUN apt install -y tzdata \
&& ln -sf /usr/share/zoneinfo/Asia/Tokyo /etc/localtime
RUN apt install -y vim
RUN apt install -y mysql-server mysql-client
RUN apt install -y expect
# MySQLを外部から接続可能にする
# \s*はスペースが0個以上
RUN sed -i -e"s/^bind-address\s*=\s*127.0.0.1/bind-address = 0.0.0.0/" /etc/mysql/mysql.conf.d/mysqld.cnf

COPY init_mysql.sh /root/
COPY init_test_db.sql /root/

ENTRYPOINT [ "/root/init_mysql.sh" ]