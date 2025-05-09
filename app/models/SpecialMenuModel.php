<?php
require_once "app/database/database.php";
class SpecialMenuModel
{
    private $db;

    public function __construct()
    {
        require_once "app/database/database.php";
        $database = new database();
        $this->db = $database->connect();
    }

    public function getAllMenuItems()
    {
        $query = "SELECT * FROM special_menu ORDER BY id ASC";
        $result = $this->db->query($query);

        $items = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $items[] = $row;
            }
        }

        return $items;
    }

    public function getMenuItemCount()
    {
        $query = "SELECT COUNT(*) as count FROM special_menu";
        $result = $this->db->query($query);
        $row = $result->fetch_assoc();
        return $row['count'];
    }

    public function addMenuItem($image_path, $title)
    {
        $stmt = $this->db->prepare("INSERT INTO special_menu (image_path, title) VALUES (?, ?)");
        $stmt->bind_param("ss", $image_path, $title);
        $success = $stmt->execute();
        $stmt->close();

        return $success;
    }

    public function getMenuItemById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM special_menu WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $item = $result->fetch_assoc();
        $stmt->close();

        return $item;
    }

    public function updateMenuItem($id, $image_path, $title)
    {
        $stmt = $this->db->prepare("UPDATE special_menu SET image_path = ?, title = ? WHERE id = ?");
        $stmt->bind_param("ssi", $image_path, $title, $id);
        $success = $stmt->execute();
        $stmt->close();

        return $success;
    }

    public function deleteMenuItem($id)
    {
        
        $item = $this->getMenuItemById($id);
        if (!$item) {
            return false;
        }

      
        $stmt = $this->db->prepare("DELETE FROM special_menu WHERE id = ?");
        $stmt->bind_param("i", $id);
        $success = $stmt->execute();
        $stmt->close();

      
        if ($success && $item['image_path'] && file_exists($item['image_path']) && strpos($item['image_path'], 'default') === false) {
            @unlink($item['image_path']);
        }

        return $success;
    }

    public function deleteAllMenuItems()
    {
       
        $items = $this->getAllMenuItems();
        
    
        $query = "DELETE FROM special_menu";
        $success = $this->db->query($query);
        
       
        if ($success) {
            foreach ($items as $item) {
                if ($item['image_path'] && file_exists($item['image_path']) && strpos($item['image_path'], 'default') === false) {
                    @unlink($item['image_path']);
                }
            }
        }
        
        return $success;
    }
}