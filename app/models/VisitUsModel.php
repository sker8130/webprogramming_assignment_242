<?php
class VisitUsModel
{
    private $db;

    public function __construct()
    {
        require_once "app/database/database.php";
        $database = new database();
        $this->db = $database->connect();
    }

    public function getVisitUsData()
    {
        $query = "SELECT * FROM visit_us LIMIT 1";
        $result = $this->db->query($query);

        if ($result && $result->num_rows > 0) {
            return $result->fetch_assoc();
        } else {
            return null;
        }
    }

    public function updateVisitUsData($address, $phone, $email, $working_hours_description, $dphone)
    {
     
        $query = "SELECT * FROM visit_us LIMIT 1";
        $result = $this->db->query($query);

        if ($result && $result->num_rows > 0) {
       
            $stmt = $this->db->prepare("UPDATE visit_us SET address = ?, phone = ?, email = ?, working_hours_description = ?, dphone =? WHERE id = 1");
            $stmt->bind_param("sssss", $address, $phone, $email, $working_hours_description, $dphone);
            $success = $stmt->execute();
            $stmt->close();
        } else {
            
            $stmt = $this->db->prepare("INSERT INTO visit_us (address, phone, email, working_hours_description, dphone) VALUES (?, ?, ?, ?,?)");
            $stmt->bind_param("sssss", $address, $phone, $email, $working_hours_description, $dphone);
            $success = $stmt->execute();
            $stmt->close();
        }

        return isset($success) ? $success : false;
    }
}