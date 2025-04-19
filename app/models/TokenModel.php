<?php
require_once "app/database/database.php";
class TokenModel
{
    private $db;

    public function __construct()
    {
        $this->db = (new database())->connect();
    }

    public function checkTokenExists($token)
    {
        $stmt = $this->db->prepare("select * from tokens where token = ? and expiresAt > NOW()");
        $stmt->bind_param("s", $token);

        $exists = $stmt->execute();
        $stmt->close();
        return $exists;
    }

    public function add($userID, $token, $expiresAt)
    {
        $stmt = $this->db->prepare("insert into tokens (UserID, token, expiresAt) values (?, ?, ?)");
        $stmt->bind_param("sss", $userID, $token, $expiresAt);

        $exists = $stmt->execute();
        $stmt->close();
        return $exists;
    }

    public function delete($token)
    {
        $stmt = $this->db->prepare("delete from tokens where token = ?");
        $stmt->bind_param("s", $token);

        $exists = $stmt->execute();
        $stmt->close();
        return $exists;
    }
}