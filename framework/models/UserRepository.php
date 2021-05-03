<?php

class UserRepository extends DBRepository
{
    private $user_name = ':user_name';
    private $password = ':password';
    private $created_at = ':created_at';
    private $db_name = 'MY_BLOG_DB';

    /**
     * userテーブルに値を挿入する
     */
    public function insert($user_name, $password)
    {
        $password = $this->hashPassword($password);
        $now = new DateTime();

        $sql = "INSERT INTO ". $this->db_name .".user(user_name, password, created_at) " .
               "VALUES($this->user_name, $this->password, $this->created_at)";

        $stmt = $this->execute($sql, array(
            $this->user_name  => $user_name,
            $this->password   => $password,
            $this->created_at => $now->format('Y-m-d H:i:s'),
        ));
    }

    /**
     * userテーブルからユーザ名より情報を取得する
     */
    public function fetchByUserName($user_name)
    {
        $sql = "SELECT * FROM ". $this->db_name . ".user WHERE user_name = :user_name";
        return $this->fetch($sql, array(
            $this->user_name => $user_name,
        ));
    }

    /**
     * パスワードのハッシュ値を取得する
     */
    public function hashPassword($password)
    {
        return sha1($password . 'SecretKey');
    }

    /**
     * 指定ユーザ名が重複していないか確認する
     */
    public function isUniqueUserName($user_name)
    {
        $sql = "SELECT COUNT(id) as count FROM ". $this->db_name .".user WHERE user_name = " . $this->user_name;
        $row = $this->fetch($sql, array(
            $this->user_name => $user_name,
        ));
        
        if($row['count'] === '0')
        {
            return true;
        }
        return false;
    }

    
}