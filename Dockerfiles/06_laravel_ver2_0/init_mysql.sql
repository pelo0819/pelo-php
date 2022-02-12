
-- パスワード設定ポリシーを下げる
SET GLOBAL validate_password.policy=low;
-- ユーザー作成
DROP USER IF EXISTS pelo;
CREATE USER pelo@'%' IDENTIFIED BY '0819Tobita';
-- db作成
DROP DATABASE IF EXISTS CANVAS_DB;
CREATE DATABASE CANVAS_DB;
-- table作成
CREATE TABLE CANVAS_DB.users(
    id INTEGER AUTO_INCREMENT,
    user_name VARCHAR(20) NOT NULL,
    email VARCHAR(255) NOT NULL,
    password VARCHAR(40) NOT NULL,
    is_login tinyint(1),
    last_login DATETIME,
    created_at DATETIME NOT NULL,
    PRIMARY KEY(id),
    UNIQUE KEY user_name_index(user_name)
) ENGINE = INNODB;

-- ユーザの権限付与
GRANT ALL PRIVILEGES ON CANVAS_DB.* TO pelo@'%';