#!/bin/sh

# MySQL起動
service mysql restart

# MYSQLの初期設定
init_mysql () {
    # 対話型なのでexpectを使用して自動で答えるようにする
    timeout=10
    password="0819Tobita"
    command="mysql_secure_installation"
    expect -c "
    set timeout ${timeout}
    spawn ${command}
    expect {
        \"Press y|Y for Yes, any other key for No\" {
            send \"y\n\"
            exp_continue
        }
        \"Please enter 0 = LOW, 1 = MEDIUM and 2 = STRONG:\" {
            send \"1\n\"
            exp_continue
        }
        -re \"(Re-enter new|New) password:\" {
            send \"${password}\n\"
            exp_continue
        }
    }
    "
    # MySQLのuser, db, tableを作成
    mysql -u root < /root/init_mysql.sql
}


if [ ! -e '/init' ]; then
    echo '[*] initialize MySQL.'
    init_mysql
    echo '[*] make directory for initialized check.'
    touch /init
fi

/bin/bash



