<?php
class PopularDishesModel
{
    private $db;
    private $MAX_DISHES = 5;

    public function __construct()
    {
        require_once "app/database/database.php";
        $database = new database();
        $this->db = $database->connect();
    }

    public function getAllDishes()
    {
        $query = "SELECT * FROM popular_dishes ORDER BY dish_order ASC";
        $result = $this->db->query($query);

        $dishes = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $dishes[] = $row;
            }
        }

        return $dishes;
    }

    public function getDishCount()
    {
        $query = "SELECT COUNT(*) as count FROM popular_dishes";
        $result = $this->db->query($query);
        $row = $result->fetch_assoc();
        return $row['count'];
    }

    public function addDish($image_path, $alt_text)
    {
    
        if ($this->getDishCount() >= $this->MAX_DISHES) {
            return false;
        }

    
        $query = "SELECT MAX(dish_order) as max_order FROM popular_dishes";
        $result = $this->db->query($query);
        $row = $result->fetch_assoc();
        $next_order = ($row['max_order'] === null) ? 1 : $row['max_order'] + 1;

    
        $stmt = $this->db->prepare("INSERT INTO popular_dishes (image_path, alt_text, dish_order) VALUES (?, ?, ?)");
        $stmt->bind_param("ssi", $image_path, $alt_text, $next_order);
        $success = $stmt->execute();
        $stmt->close();

        return $success;
    }

    public function getDishById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM popular_dishes WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $dish = $result->fetch_assoc();
        $stmt->close();

        return $dish;
    }

    public function updateDish($id, $image_path, $alt_text)
    {
     
        if (!$this->deleteDish($id)) {
            return false;
        }

    
        return $this->addDish($image_path, $alt_text);
    }

    public function deleteDish($id)
    {
     
        $dish = $this->getDishById($id);
        if (!$dish) {
            return false;
        }

      
        $stmt = $this->db->prepare("DELETE FROM popular_dishes WHERE id = ?");
        $stmt->bind_param("i", $id);
        $success = $stmt->execute();
        $stmt->close();

   
        if ($success && $dish['image_path'] && file_exists($dish['image_path']) && strpos($dish['image_path'], 'default') === false) {
            @unlink($dish['image_path']);
        }

        return $success;
    }

    public function deleteAllDishes()
    {
    
        $dishes = $this->getAllDishes();
        
    
        $query = "DELETE FROM popular_dishes";
        $success = $this->db->query($query);
        
      
        if ($success) {
            foreach ($dishes as $dish) {
                if ($dish['image_path'] && file_exists($dish['image_path']) && strpos($dish['image_path'], 'default') === false) {
                    @unlink($dish['image_path']);
                }
            }
        }
        
        return $success;
    }

    public function reorderDishes()
    {
    
        $query = "SELECT id FROM popular_dishes ORDER BY dish_order ASC";
        $result = $this->db->query($query);
        
        $order = 1;
        $success = true;
        
       
        while ($row = $result->fetch_assoc()) {
            $stmt = $this->db->prepare("UPDATE popular_dishes SET dish_order = ? WHERE id = ?");
            $stmt->bind_param("ii", $order, $row['id']);
            $success = $success && $stmt->execute();
            $stmt->close();
            $order++;
        }
        
        return $success;
    }
}