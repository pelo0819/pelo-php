FROM ubuntu:latest

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