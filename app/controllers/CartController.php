<?php
require_once "app/models/ItemsModel.php";
require_once "app/models/UserModel.php"; // For checkUsernameExists

class CartController
{
    // Used by: cart.php (display cart contents, handle item deletion, and quantity adjustment)
    public function index()
    {
        $itemsModel = new ItemsModel();
        $userModel = new UserModel(); // For checkUsernameExists

        // Check if user is logged in
        if (!isset($_SESSION["mySession"])) {
            // Redirect to login page or handle as needed
            header("Location: /webprogramming_assignment_242/login");
            exit;
        }

        // Get UserID
        $userId = $userModel->checkUsernameExists($_SESSION["mySession"]);
        if (!$userId) {
            // Handle user not found (e.g., redirect or show error)
            header("Location: /webprogramming_assignment_242/login");
            exit;
        }

        // Get pending order
        $order = $itemsModel->getPendingOrder($userId);

        // Fetch shipper details if order exists
        $shipper = null;
        if ($order && isset($order['ShipperID'])) {
            $shipper = $itemsModel->getShipperById($order['ShipperID']);
        }

        // Handle delete item request
        $deleteSuccess = false;
        $deleteError = null;
        if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["action"]) && $_POST["action"] === "delete" && isset($_POST["product_id"])) {
            if (!$order) {
                $deleteError = "No pending order found.";
            } else {
                $productId = (int)$_POST["product_id"];
                if ($itemsModel->deleteItemFromOrder($order['OrderID'], $productId)) {
                    // Update the total amount after deletion
                    if ($itemsModel->updateOrderTotal($order['OrderID'])) {
                        $deleteSuccess = true;
                    } else {
                        $deleteError = "Failed to update order total after deletion.";
                    }
                } else {
                    $deleteError = "Failed to delete item from order.";
                }
            }
            // Redirect to avoid form resubmission on refresh
            header("Location: /webprogramming_assignment_242/cart");
            exit;
        }

        // Handle quantity adjustment request
        $quantitySuccess = false;
        $quantityError = null;
        if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["action"]) && $_POST["action"] === "update_quantity" && isset($_POST["product_id"]) && isset($_POST["change"])) {
            if (!$order) {
                $quantityError = "No pending order found.";
            } else {
                $productId = (int)$_POST["product_id"];
                $change = $_POST["change"];
                if ($change !== 'increase' && $change !== 'decrease') {
                    $quantityError = "Invalid quantity change.";
                } else {
                    if ($itemsModel->updateItemQuantity($order['OrderID'], $productId, $change)) {
                        // Update the total amount after quantity adjustment
                        if ($itemsModel->updateOrderTotal($order['OrderID'])) {
                            $quantitySuccess = true;
                        } else {
                            $quantityError = "Failed to update order total after quantity adjustment.";
                        }
                    } else {
                        $quantityError = "Failed to update quantity. Quantity cannot be less than 1.";
                    }
                }
            }
            // Redirect to avoid form resubmission on refresh
            header("Location: /webprogramming_assignment_242/cart");
            exit;
        }

        // Fetch order items for display
        $orderItems = $order ? $itemsModel->getOrderItems($order['OrderID']) : null;

        require_once "app/views/user/cart/cart.php";
    }
}
?>