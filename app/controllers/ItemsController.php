<?php
require_once "app/models/ItemsModel.php";
require_once "app/models/UserModel.php"; // Added to use checkUsernameExists

class ItemsController
{
    // Used by: items.php (display all items or search results)
    public function index()
    {
        $itemsModel = new ItemsModel();

        // Handle search
        $keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';
        if ($keyword) {
            $items = $itemsModel->searchItems($keyword);
        } else {
            $items = $itemsModel->getAllItems();
        }

        require_once "app/views/user/items/items.php";
    }

    // Used by: itemdetail.php (display item details and handle ordering)
    public function detail()
    {
        $itemsModel = new ItemsModel();
        $userModel = new UserModel(); // For checkUsernameExists

        // Get the ProductID from the query parameter
        $productId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

        // Validate ProductID and fetch item
        if ($productId <= 0) {
            $item = null;
            $items = $itemsModel->getAllItems(); // Still show all items in grid
        } else {
            $item = $itemsModel->getItemById($productId);
            $items = $itemsModel->getAllItems(); // Fetch all items for the grid
        }

        // Handle order submission
        $orderSuccess = false;
        $orderError = null;
        if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["order_item"]) && isset($_SESSION["mySession"])) {
            // Get UserID from username using UserModel
            $checkUsernameExists = $userModel->checkUsernameExists($_SESSION["mySession"]);
            $checkEmailExists = $userModel->checkEmailExists($_SESSION["mySession"]);
            $userId = $checkUsernameExists ? $checkUsernameExists["UserID"] : $checkEmailExists["UserID"];
            if (!$userId) {
                $orderError = "User not found.";
            } else {
                // Check for a pending order
                $order = $itemsModel->getPendingOrder($userId);
                if (!$order) {
                    // Create a new order (using a default ShipperID of 1 for now)
                    $totalAmount = $item['Price']; // Initial total is the price of this item
                    $shipperId = 1; // Hardcoded for now; adjust later
                    $orderId = $itemsModel->createOrder($userId, $totalAmount, $shipperId);
                    if (!$orderId) {
                        $orderError = "Failed to create order.";
                    } else {
                        $order = ['OrderID' => $orderId];
                    }
                }

                // Check if item is already in the order
                if (!$orderError) {
                    $orderItems = $itemsModel->getOrderItems($order['OrderID']);
                    $isInCart = false;
                    while ($orderItem = $orderItems->fetch_assoc()) {
                        if ($orderItem['ProductID'] == $productId) {
                            $isInCart = true;
                            break;
                        }
                    }

                    if (!$isInCart) {
                        $quantity = 1; // Default quantity when adding to cart
                        if ($itemsModel->addItemToOrder($order['OrderID'], $productId, $quantity)) {
                            // Update the total amount
                            if ($itemsModel->updateOrderTotal($order['OrderID'])) {
                                $orderSuccess = true;
                            } else {
                                $orderError = "Failed to update order total.";
                            }
                        } else {
                            $orderError = "Failed to add item to order.";
                        }
                    } else {
                        $orderError = "Item is already in your cart.";
                    }
                }
            }
        }

        // Recompute $isInCart for display
        $isInCart = false;
        if (isset($_SESSION["mySession"]) && $item) {
            $userId = $userModel->checkUsernameExists($_SESSION["mySession"]);
            if ($userId) {
                $order = $itemsModel->getPendingOrder($userId["UserID"]);
                if ($order) {
                    $orderItems = $itemsModel->getOrderItems($order['OrderID']);
                    while ($orderItem = $orderItems->fetch_assoc()) {
                        if ($orderItem['ProductID'] == $item['ProductID']) {
                            $isInCart = true;
                            break;
                        }
                    }
                }
            }
        }

        require_once "app/views/user/itemdetail/itemdetail.php";
    }
}
?>
