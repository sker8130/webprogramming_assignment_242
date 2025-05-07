<?php
require_once "app/database/database.php";

class ItemsModel
{
    private $db;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->connect();
    }

    // Used by: items.php (to display all items)
    public function getAllItems()
    {
        $stmt = $this->db->prepare("SELECT p.*, c.CategoryName FROM products p JOIN categories c ON p.CategoryID = c.CategoryID");
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        return $result;
    }

    // Used by: items.php (to search for items)
    public function searchItems($keyword)
    {
        $stmt = $this->db->prepare("SELECT p.*, c.CategoryName FROM products p JOIN categories c ON p.CategoryID = c.CategoryID WHERE p.ProductName LIKE ? OR c.CategoryName LIKE ?");
        $keyword = "%$keyword%";
        $stmt->bind_param("ss", $keyword, $keyword); // Bind the keyword to both conditions
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        return $result;
    }

    // Used by: itemdetail.php (to display item details)
    public function getItemById($productId)
    {
        $stmt = $this->db->prepare("SELECT p.*, c.CategoryName FROM products p JOIN categories c ON p.CategoryID = c.CategoryID WHERE p.ProductID = ?");
        $stmt->bind_param("i", $productId);
        $stmt->execute();
        $result = $stmt->get_result();
        $item = $result->fetch_assoc();
        $stmt->close();
        return $item; // Returns the item as an associative array or null if not found
    }

    // Used by: itemdetail.php, cart.php (to check for a pending order)
    public function getPendingOrder($userId)
    {
        $stmt = $this->db->prepare("SELECT * FROM orders WHERE UserID = ? AND OrderStatus = 'Pending' LIMIT 1");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        $order = $result->fetch_assoc();
        $stmt->close();
        return $order;
    }

    // Used by: itemdetail.php (to create a new order when adding an item)
    public function createOrder($userId, $totalAmount, $shipperId)
    {
        $stmt = $this->db->prepare("INSERT INTO orders (UserID, TotalAmount, OrderStatus, CreateAt, PayAt, ShipperID) 
                                    VALUES (?, ?, 'Pending', NOW(), NOW(), ?)");
        $stmt->bind_param("idi", $userId, $totalAmount, $shipperId);
        $result = $stmt->execute();
        if ($result) {
            $orderId = $this->db->insert_id; // Get the newly created OrderID
            $stmt->close();
            return $orderId;
        }
        $stmt->close();
        return false;
    }

    // Used by: itemdetail.php (to add an item to the order)
    public function addItemToOrder($orderId, $productId, $quantity)
    {
        $stmt = $this->db->prepare("INSERT INTO order_items (OrderID, ProductID, Quantity) VALUES (?, ?, ?)");
        $stmt->bind_param("iii", $orderId, $productId, $quantity);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    // Used by: itemdetail.php, cart.php (to recalculate the total amount of an order)
    public function updateOrderTotal($orderId)
    {
        $stmt = $this->db->prepare("SELECT oi.Quantity, p.Price 
                                    FROM order_items oi 
                                    JOIN products p ON oi.ProductID = p.ProductID 
                                    WHERE oi.OrderID = ?");
        $stmt->bind_param("i", $orderId);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $totalAmount = 0;
        while ($item = $result->fetch_assoc()) {
            $totalAmount += $item['Price'] * $item['Quantity'];
        }
        $stmt->close();

        // Update the total amount in the orders table
        $updateStmt = $this->db->prepare("UPDATE orders SET TotalAmount = ? WHERE OrderID = ?");
        $updateStmt->bind_param("di", $totalAmount, $orderId);
        $result = $updateStmt->execute();
        $updateStmt->close();
        return $result;
    }

    // Used by: cart.php (to get all items in an order)
    public function getOrderItems($orderId)
    {
        $stmt = $this->db->prepare("SELECT oi.*, p.ProductName, p.Price, p.Image 
                                    FROM order_items oi 
                                    JOIN products p ON oi.ProductID = p.ProductID 
                                    WHERE oi.OrderID = ?");
        $stmt->bind_param("i", $orderId);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        return $result;
    }

    // Used by: cart.php (to delete an item from the order)
    public function deleteItemFromOrder($orderId, $productId)
    {
        $stmt = $this->db->prepare("DELETE FROM order_items WHERE OrderID = ? AND ProductID = ?");
        $stmt->bind_param("ii", $orderId, $productId);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    // Used by: cart.php (to adjust the quantity of an item in the order)
    public function updateItemQuantity($orderId, $productId, $change)
    {
        // First, get the current quantity
        $stmt = $this->db->prepare("SELECT Quantity FROM order_items WHERE OrderID = ? AND ProductID = ?");
        $stmt->bind_param("ii", $orderId, $productId);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $stmt->close();

        if (!$row) {
            return false; // Item not found
        }

        $currentQuantity = $row['Quantity'];
        $newQuantity = $change === 'increase' ? $currentQuantity + 1 : $currentQuantity - 1;

        // Prevent quantity from going below 1
        if ($newQuantity < 1) {
            return false; // Use deleteItemFromOrder to remove the item instead
        }

        // Update the quantity
        $updateStmt = $this->db->prepare("UPDATE order_items SET Quantity = ? WHERE OrderID = ? AND ProductID = ?");
        $updateStmt->bind_param("iii", $newQuantity, $orderId, $productId);
        $result = $updateStmt->execute();
        $updateStmt->close();
        return $result;
    }

    // Used by: cart.php (to get shipper details)
    public function getShipperById($shipperId)
    {
        $stmt = $this->db->prepare("SELECT ShipperName, CarID, Phone, Avatar, Gender FROM shippers WHERE ShipperID = ?");
        $stmt->bind_param("i", $shipperId);
        $stmt->execute();
        $result = $stmt->get_result();
        $shipper = $result->fetch_assoc();
        $stmt->close();
        return $shipper;
    }
}
?>