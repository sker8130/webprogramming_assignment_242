<?php
session_start();
require_once "app/models/ItemsModel.php";
require_once "app/models/UserModel.php";
require_once "app/models/TokenModel.php";

class AdminOrdersController
{
    private $itemsModel;
    private $userModel;
    private $tokenModel;
    
    public function __construct()
    {
        $this->itemsModel = new ItemsModel();
        $this->userModel = new UserModel();
        $this->tokenModel = new TokenModel();
    }

    // Used by: admin/orders/orders.php (display all orders)
    public function adminIndex()
    {
        // Restore session if expired but cookie exists
        if (!isset($_SESSION["mySession"]) && isset($_COOKIE["usernameEmail"])) {
            $token = $_COOKIE["usernameEmail"];
            if ($this->tokenModel->checkTokenExists($token)) {
                $user = $this->userModel->getUserByToken($token);
                if ($user) {
                    $_SESSION["mySession"] = $user["Username"];
                }
            }
        }
        // Redirect non-admin users
        if (!isset($_SESSION["mySession"]) || (isset($_SESSION["mySession"]) && ($_SESSION["mySession"] != "admin" && $_SESSION["mySession"] != "admin@gmail.com"))) {
            header("Location: /webprogramming_assignment_242/");
            exit;
        }

        // Generate CSRF token
        if (!isset($_SESSION["csrf_token"])) {
            $_SESSION["csrf_token"] = bin2hex(random_bytes(32));
        }

        // Fetch all orders and shippers
        $orders = $this->itemsModel->getAllOrders();
        $shippers = $this->itemsModel->getShippers();

        // Check for success/error messages
        $successMessage = isset($_SESSION["success_message"]) ? $_SESSION["success_message"] : null;
        $errorMessage = isset($_SESSION["error_message"]) ? $_SESSION["error_message"] : null;

        // Clear messages after displaying
        unset($_SESSION["success_message"]);
        unset($_SESSION["error_message"]);

        // Pass itemsModel to the view
        $itemsModel = $this->itemsModel;

        require_once "app/views/admin/orders/orders.php";
    }

    // Used by: admin/orders/orders.php (update order status)
    public function updateStatus()
    {
        // Restore session if expired but cookie exists
        if (!isset($_SESSION["mySession"]) && isset($_COOKIE["usernameEmail"])) {
            $token = $_COOKIE["usernameEmail"];
            if ($this->tokenModel->checkTokenExists($token)) {
                $user = $this->userModel->getUserByToken($token);
                if ($user) {
                    $_SESSION["mySession"] = $user["Username"];
                }
            }
        }
        // Redirect non-admin users
        if (!isset($_SESSION["mySession"]) || (isset($_SESSION["mySession"]) && ($_SESSION["mySession"] != "admin" && $_SESSION["mySession"] != "admin@gmail.com"))) {
            header("Location: /webprogramming_assignment_242/");
            exit;
        }

        if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["orderId"]) && isset($_POST["status"]) && isset($_POST["csrf_token"])) {
            // Validate CSRF token
            if ($_POST["csrf_token"] !== $_SESSION["csrf_token"]) {
                $_SESSION["error_message"] = "Invalid CSRF token.";
                header("Location: /webprogramming_assignment_242/admin/cart");
                exit;
            }

            $orderId = intval($_POST["orderId"]);
            $status = trim($_POST["status"]);
            $allowedStatuses = ['Pending', 'Processing', 'Completed', 'Cancelled'];

            // Validate inputs
            if ($orderId <= 0 || !in_array($status, $allowedStatuses)) {
                $_SESSION["error_message"] = "Invalid order ID or status.";
                header("Location: /webprogramming_assignment_242/admin/cart");
                exit;
            }

            // Update status
            if ($this->itemsModel->updateOrderStatus($orderId, $status)) {
                $_SESSION["success_message"] = "Order status updated successfully.";
            } else {
                $_SESSION["error_message"] = "Failed to update order status.";
            }
        } else {
            $_SESSION["error_message"] = "Invalid request.";
        }

        header("Location: /webprogramming_assignment_242/admin/cart");
        exit;
    }

    // Used by: admin/orders/orders.php (update order shipper)
    public function updateShipper()
    {
        // Restore session if expired but cookie exists
        if (!isset($_SESSION["mySession"]) && isset($_COOKIE["usernameEmail"])) {
            $token = $_COOKIE["usernameEmail"];
            if ($this->tokenModel->checkTokenExists($token)) {
                $user = $this->userModel->getUserByToken($token);
                if ($user) {
                    $_SESSION["mySession"] = $user["Username"];
                }
            }
        }
        // Redirect non-admin users
        if (!isset($_SESSION["mySession"]) || (isset($_SESSION["mySession"]) && ($_SESSION["mySession"] != "admin" && $_SESSION["mySession"] != "admin@gmail.com"))) {
            header("Location: /webprogramming_assignment_242/");
            exit;
        }

        if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["orderId"]) && isset($_POST["shipperId"]) && isset($_POST["csrf_token"])) {
            // Validate CSRF token
            if ($_POST["csrf_token"] !== $_SESSION["csrf_token"]) {
                $_SESSION["error_message"] = "Invalid CSRF token.";
                header("Location: /webprogramming_assignment_242/admin/cart");
                exit;
            }

            $orderId = intval($_POST["orderId"]);
            $shipperId = intval($_POST["shipperId"]);

            // Validate inputs
            if ($orderId <= 0 || $shipperId <= 0) {
                $_SESSION["error_message"] = "Invalid order ID or shipper ID.";
                header("Location: /webprogramming_assignment_242/admin/cart");
                exit;
            }

            // Update shipper
            if ($this->itemsModel->updateOrderShipper($orderId, $shipperId)) {
                $_SESSION["success_message"] = "Shipper updated successfully.";
            } else {
                $_SESSION["error_message"] = "Failed to update shipper.";
            }
        } else {
            $_SESSION["error_message"] = "Invalid request.";
        }

        header("Location: /webprogramming_assignment_242/admin/cart");
        exit;
    }
}
?>