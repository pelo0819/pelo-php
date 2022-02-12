FROM ubuntu:latest

RUN apt update
# タイムゾーンの設定
RUN apt install -y tzdata \
&& ln -sf /usr/share/zoneinfo/Asia/Tokyo /etc/localtime
RUN apt install -y vim
RUN apt update
RUN apt install -y apache2
RUN apt install -y curl