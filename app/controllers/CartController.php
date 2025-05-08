<?php
require_once "app/models/ItemsModel.php";
require_once "app/models/UserModel.php"; // For checkUsernameExists

class CartController
{
    // Used by: cart.php (display cart contents, handle item deletion, quantity adjustment, and checkout)
    public function index()
    {
        session_start(); // Ensure session is started

        $itemsModel = new ItemsModel();
        $userModel = new UserModel(); // For checkUsernameExists

        // Check if user is logged in
        if (!isset($_SESSION["mySession"])) {
            // Redirect to login page or handle as needed
            header("Location: /webprogramming_assignment_242/login");
            exit;
        }

        // Generate CSRF token if not set (redundant since cart.php already does this, but for safety)
        if (!isset($_SESSION["csrf_token"])) {
            $_SESSION["csrf_token"] = bin2hex(random_bytes(32));
        }

        // Get UserID
        $checkUsernameExists = $userModel->checkUsernameExists($_SESSION["mySession"]);
        $checkEmailExists = $userModel->checkEmailExists($_SESSION["mySession"]);
        $userId = $checkUsernameExists ? $checkUsernameExists["UserID"] : $checkEmailExists["UserID"];
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

        // Handle checkout request
        $checkoutSuccess = false;
        $checkoutError = null;
        if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["action"]) && $_POST["action"] === "checkout") {
            // Validate CSRF token
            if (!isset($_POST["csrf_token"]) || $_POST["csrf_token"] !== $_SESSION["csrf_token"]) {
                $_SESSION["checkoutError"] = "Invalid CSRF token.";
            } else {
                if (!$order) {
                    $_SESSION["checkoutError"] = "No pending order found.";
                } else {
                    // Update order status to Processing
                    if ($itemsModel->updateOrderStatus($order['OrderID'], 'Processing')) {
                        $_SESSION["checkoutSuccess"] = true;
                        // Re-fetch the pending order (should be null now)
                        $order = $itemsModel->getPendingOrder($userId);
                        $shipper = null; // Clear shipper since there's no pending order
                    } else {
                        $_SESSION["checkoutError"] = "Failed to process order.";
                    }
                }
            }
            // Redirect to avoid form resubmission on refresh
            header("Location: /webprogramming_assignment_242/cart");
            exit;
        }

        // Retrieve and clear checkout messages from session
        $checkoutSuccess = isset($_SESSION["checkoutSuccess"]) ? $_SESSION["checkoutSuccess"] : false;
        $checkoutError = isset($_SESSION["checkoutError"]) ? $_SESSION["checkoutError"] : null;
        unset($_SESSION["checkoutSuccess"]);
        unset($_SESSION["checkoutError"]);

        // Handle delete item request
        $deleteSuccess = false;
        $deleteError = null;
        if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["action"]) && $_POST["action"] === "delete" && isset($_POST["product_id"])) {
            // Validate CSRF token
            if (!isset($_POST["csrf_token"]) || $_POST["csrf_token"] !== $_SESSION["csrf_token"]) {
                $_SESSION["deleteError"] = "Invalid CSRF token.";
            } else {
                if (!$order) {
                    $_SESSION["deleteError"] = "No pending order found.";
                } else {
                    $productId = (int)$_POST["product_id"];
                    if ($itemsModel->deleteItemFromOrder($order['OrderID'], $productId)) {
                        // Update the total amount after deletion
                        if ($itemsModel->updateOrderTotal($order['OrderID'])) {
                            $_SESSION["deleteSuccess"] = true;
                        } else {
                            $_SESSION["deleteError"] = "Failed to update order total after deletion.";
                        }
                    } else {
                        $_SESSION["deleteError"] = "Failed to delete item from order.";
                    }
                }
            }
            // Redirect to avoid form resubmission on refresh
            header("Location: /webprogramming_assignment_242/cart");
            exit;
        }

        // Retrieve and clear delete messages from session
        $deleteSuccess = isset($_SESSION["deleteSuccess"]) ? $_SESSION["deleteSuccess"] : false;
        $deleteError = isset($_SESSION["deleteError"]) ? $_SESSION["deleteError"] : null;
        unset($_SESSION["deleteSuccess"]);
        unset($_SESSION["deleteError"]);

        // Handle quantity adjustment request
        $quantitySuccess = false;
        $quantityError = null;
        if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["action"]) && $_POST["action"] === "update_quantity" && isset($_POST["product_id"]) && isset($_POST["change"])) {
            // Validate CSRF token
            if (!isset($_POST["csrf_token"]) || $_POST["csrf_token"] !== $_SESSION["csrf_token"]) {
                $_SESSION["quantityError"] = "Invalid CSRF token.";
            } else {
                if (!$order) {
                    $_SESSION["quantityError"] = "No pending order found.";
                } else {
                    $productId = (int)$_POST["product_id"];
                    $change = $_POST["change"];
                    if ($change !== 'increase' && $change !== 'decrease') {
                        $_SESSION["quantityError"] = "Invalid quantity change.";
                    } else {
                        if ($itemsModel->updateItemQuantity($order['OrderID'], $productId, $change)) {
                            // Update the total amount after quantity adjustment
                            if ($itemsModel->updateOrderTotal($order['OrderID'])) {
                                $_SESSION["quantitySuccess"] = true;
                            } else {
                                $_SESSION["quantityError"] = "Failed to update order total after quantity adjustment.";
                            }
                        } else {
                            $_SESSION["quantityError"] = "Failed to update quantity. Quantity cannot be less than 1.";
                        }
                    }
                }
            }
            // Redirect to avoid form resubmission on refresh
            header("Location: /webprogramming_assignment_242/cart");
            exit;
        }

        // Retrieve and clear quantity messages from session
        $quantitySuccess = isset($_SESSION["quantitySuccess"]) ? $_SESSION["quantitySuccess"] : false;
        $quantityError = isset($_SESSION["quantityError"]) ? $_SESSION["quantityError"] : null;
        unset($_SESSION["quantitySuccess"]);
        unset($_SESSION["quantityError"]);

        // Fetch order items for display
        $orderItems = $order ? $itemsModel->getOrderItems($order['OrderID']) : null;

        require_once "app/views/user/cart/cart.php";
    }
}
?>
