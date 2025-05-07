<?php
require_once "app/models/ItemsModel.php";
require_once "app/models/UserModel.php";
require_once "app/models/TokenModel.php";

class AdminItemsController
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

    // Used by: admin/items.php (display product list with search)
    public function adminIndex()
    {
        session_start();

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

        // Handle search via POST
        $productId = null;
        $name = null;
        $categoryId = null;
        $oldInput = [];

        if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["searchForItems"])) {
            $productId = isset($_POST["productIDForItems"]) && $_POST["productIDForItems"] !== "" ? intval($_POST["productIDForItems"]) : null;
            $name = isset($_POST["nameForItems"]) && $_POST["nameForItems"] !== "" ? trim($_POST["nameForItems"]) : null;
            $categoryId = isset($_POST["categoryForItems"]) && $_POST["categoryForItems"] !== "" ? intval($_POST["categoryForItems"]) : null;

            // Store old input for form repopulation
            $oldInput["productIDForItems"] = $productId !== null ? $productId : "";
            $oldInput["nameForItems"] = $name !== null ? $name : "";
            $oldInput["categoryForItems"] = $categoryId !== null ? $categoryId : "";
        }

        // Fetch items based on search criteria
        if ($productId !== null || $name !== null || $categoryId !== null) {
            $items = $this->itemsModel->searchItemsAdmin($productId, $name, $categoryId);
        } else {
            $items = $this->itemsModel->getAllItems();
        }

        // Fetch categories for add/edit forms
        $categories = $this->itemsModel->getCategories();

        // Check for success/error messages from add/edit/delete actions
        $successMessage = isset($_SESSION["success_message"]) ? $_SESSION["success_message"] : null;
        $errorMessage = isset($_SESSION["error_message"]) ? $_SESSION["error_message"] : null;

        // Clear messages after displaying
        unset($_SESSION["success_message"]);
        unset($_SESSION["error_message"]);

        require_once "app/views/admin/items/items.php";
    }

    // Used by: admin/items.php (add a new product)
    public function add()
    {
        session_start();

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

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            // Get form data
            $name = trim($_POST["name"]);
            $price = floatval($_POST["price"]);
            $categoryId = intval($_POST["category_id"]);
            $description = trim($_POST["description"]);
            $image = null;

            // Validate inputs
            if (empty($name) || $price <= 0 || $categoryId <= 0 || empty($description)) {
                $_SESSION["error_message"] = "Please fill in all required fields with valid values.";
                header("Location: /webprogramming_assignment_242/admin/items");
                exit;
            }

            // Handle image upload
            if (isset($_FILES["image"]) && $_FILES["image"]["error"] === UPLOAD_ERR_OK) {
                $uploadDir = "app/views/user/items/img/";
                $imageName = uniqid() . "_" . basename($_FILES["image"]["name"]);
                $imagePath = $uploadDir . $imageName;

                // Validate image type and size (e.g., only images, max 5MB)
                $allowedTypes = ["image/jpeg", "image/png", "image/gif"];
                $maxSize = 5 * 1024 * 1024; // 5MB
                if (in_array($_FILES["image"]["type"], $allowedTypes) && $_FILES["image"]["size"] <= $maxSize) {
                    if (move_uploaded_file($_FILES["image"]["tmp_name"], $imagePath)) {
                        $image = $imageName;
                    } else {
                        $_SESSION["error_message"] = "Failed to upload image.";
                        header("Location: /webprogramming_assignment_242/admin/items");
                        exit;
                    }
                } else {
                    $_SESSION["error_message"] = "Invalid image type or size (max 5MB, allowed: JPEG, PNG, GIF).";
                    header("Location: /webprogramming_assignment_242/admin/items");
                    exit;
                }
            } else {
                $_SESSION["error_message"] = "Please upload an image.";
                header("Location: /webprogramming_assignment_242/admin/items");
                exit;
            }

            // Add product to database
            if ($this->itemsModel->addProduct($name, $price, $categoryId, $description, $image)) {
                $_SESSION["success_message"] = "Product added successfully.";
            } else {
                $_SESSION["error_message"] = "Failed to add product.";
            }

            header("Location: /webprogramming_assignment_242/admin/items");
            exit;
        }
        // Display add form for GET requests
        $categories = $this->itemsModel->getCategories();
        require_once "app/views/admin/items/add.php";
    }

    // Used by: admin/items.php (edit an existing product)
    public function update()
    {
        session_start();

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

        if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET["id"])) {
            // Display edit form
            $productId = intval($_GET["id"]);
            $product = $this->itemsModel->getItemById($productId);
            $categories = $this->itemsModel->getCategories();

            if (!$product) {
                $_SESSION["error_message"] = "Product not found.";
                header("Location: /webprogramming_assignment_242/admin/items");
                exit;
            }

            require_once "app/views/admin/items/update.php";
        } elseif ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["id"])) {
            // Handle form submission
            $productId = intval($_POST["id"]);
            $name = trim($_POST["name"]);
            $price = floatval($_POST["price"]);
            $categoryId = intval($_POST["category_id"]);
            $description = trim($_POST["description"]);
            $image = null;

            // Validate inputs
            if (empty($name) || $price <= 0 || $categoryId <= 0 || empty($description)) {
                $_SESSION["error_message"] = "Please fill in all required fields with valid values.";
                header("Location: /webprogramming_assignment_242/admin/items");
                exit;
            }

            // Handle image upload (optional)
            if (isset($_FILES["image"]) && $_FILES["image"]["error"] === UPLOAD_ERR_OK) {
                $uploadDir = "app/views/user/items/img/";
                $imageName = uniqid() . "_" . basename($_FILES["image"]["name"]);
                $imagePath = $uploadDir . $imageName;

                // Validate image type and size
                $allowedTypes = ["image/jpeg", "image/png", "image/gif"];
                $maxSize = 5 * 1024 * 1024; // 5MB
                if (in_array($_FILES["image"]["type"], $allowedTypes) && $_FILES["image"]["size"] <= $maxSize) {
                    if (move_uploaded_file($_FILES["image"]["tmp_name"], $imagePath)) {
                        $image = $imageName;
                    } else {
                        $_SESSION["error_message"] = "Failed to upload image.";
                        header("Location: /webprogramming_assignment_242/admin/items");
                        exit;
                    }
                } else {
                    $_SESSION["error_message"] = "Invalid image type or size (max 5MB, allowed: JPEG, PNG, GIF).";
                    header("Location: /webprogramming_assignment_242/admin/items");
                    exit;
                }
            }

            // Update product in database
            if ($this->itemsModel->updateProduct($productId, $name, $price, $categoryId, $description, $image)) {
                $_SESSION["success_message"] = "Product updated successfully.";
            } else {
                $_SESSION["error_message"] = "Failed to update product.";
            }

            header("Location: /webprogramming_assignment_242/admin/items");
            exit;
        } else {
            header("Location: /webprogramming_assignment_242/admin/items");
            exit;
        }
    }

    // Used by: admin/items.php (delete a product)
    public function delete()
    {
        session_start();

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

        if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET["id"])) {
            $productId = intval($_GET["id"]);

            // Delete product from database
            if ($this->itemsModel->deleteProduct($productId)) {
                $_SESSION["success_message"] = "Product deleted successfully.";
            } else {
                $_SESSION["error_message"] = "Failed to delete product.";
            }

            header("Location: /webprogramming_assignment_242/admin/items");
            exit;
        } else {
            header("Location: /webprogramming_assignment_242/admin/items");
            exit;
        }
    }
}
?>