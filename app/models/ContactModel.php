<?php
require_once "app/database/database.php";

class ContactModel
{
    private $db;
    private $conn;

    public function __construct()
    {
        $this->db = new database();
        $this->conn = $this->db->connect();
    }


    public function getContacts($status = '', $search = '')
    {
        $query = "SELECT * FROM contacts WHERE 1=1";
        $params = [];
        
   
        if (!empty($status)) {
            $query .= " AND Status = ?";
            $params[] = $status;
        }
        
     
        if (!empty($search)) {
            $query .= " AND (Name LIKE ? OR Email LIKE ?)";
            $params[] = "%{$search}%";
            $params[] = "%{$search}%";
        }
        

        $query .= " ORDER BY CreatedAt DESC";
        
        $stmt = $this->conn->prepare($query);
        
   
        if (!empty($params)) {
            $types = str_repeat('s', count($params));
            $stmt->bind_param($types, ...$params);
        }
        
        $stmt->execute();
        $result = $stmt->get_result();
        
        $contacts = [];
        while ($row = $result->fetch_assoc()) {
            $contacts[] = $row;
        }
        
        return $contacts;
    }
    

    public function getContactById($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM contacts WHERE ContactID = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows === 0) {
            return false;
        }
        
        return $result->fetch_assoc();
    }
    
 
    public function updateContactStatus($id, $status)
    {
        $stmt = $this->conn->prepare("UPDATE contacts SET Status = ? WHERE ContactID = ?");
        $stmt->bind_param("si", $status, $id);
        return $stmt->execute();
    }
    

    public function deleteContact($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM contacts WHERE ContactID = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
    

    public function replyToContact($id, $reply)
    {
       
        $this->ensureReplyColumnExists();
        

        $stmt = $this->conn->prepare("UPDATE contacts SET Reply = ?, Status = 'Responded' WHERE ContactID = ?");
        $stmt->bind_param("si", $reply, $id);
        return $stmt->execute();
    }
    
 
    private function ensureReplyColumnExists()
    {
      
        $result = $this->conn->query("SHOW COLUMNS FROM contacts LIKE 'Reply'");
        
   
        if ($result->num_rows === 0) {
            $this->conn->query("ALTER TABLE contacts ADD COLUMN Reply TEXT NULL AFTER Message");
        }
    }
}