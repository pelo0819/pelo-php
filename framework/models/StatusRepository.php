<?php

class StatusRepository extends DBRepository
{
    private $db_name = 'MY_BLOG_DB';
    private $table_name = 'status';
    private $user_id = ':user_id';
    private $body = ':body';
    private $created_at = ':created_at';

    public function insert($user_id, $body)
    {
        $db_table_name = $this->db_name . '.' . $this->table_name;
        $now = new DateTime();
        
        $sql = "INSERT INTO " . $db_table_name ."(user_id, body, created_at) " .
        "VALUES(" . $this->user_id . "," . $this->body . "," . $this->created_at .");";

        $stmt = $this->execute($sql, array(
            $this->user_id => $user_id,
            $this->body => $body,
            $this->created_at => $now->format('Y-m-d H:i:s'), 
        ));
    }


    public function fetchAllPersonalArchivesByUserId($user_id)
    {
        $db_table_name = $this->db_name . '.' . $this->table_name;

        $sql = "SELECT s.*, u.user_name From " . $db_table_name . " s " .
               "LEFT JOIN " . $this->db_name . ".user u ON s.user_id = u.id " .
               "WHERE u.id = " . $this->user_id . " ORDER BY s.created_at DESC;";
        
        return $this->fetchAll($sql, array(
            $this->user_id => $user_id,
        ));
    }
}