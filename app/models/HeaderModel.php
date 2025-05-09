<?php
require_once "app/database/database.php";

class HeaderModel
{
    private $db;
    private $conn;

    public function __construct()
    {
        $this->db = new database();
        $this->conn = $this->db->connect();
    }

    public function getLogo()
    {
        $sql = "SELECT image_path FROM header ORDER BY id DESC LIMIT 1";
        $result = $this->conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row['image_path'];
        } else {
   
            return "assets/compiled/svg/favicon.svg";
        }
    }
    
    public function updateLogo($imagePath)
    {
        $sql = "INSERT INTO header (image_path) VALUES (?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $imagePath);
        
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
}