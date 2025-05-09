<?php
session_start();

//nếu session hết hạn nhưng cookie còn -> đặt lại session
//nếu k có session or có mà session khác admin -> header tới login
require_once "app/models/UserModel.php";
require_once "app/models/TokenModel.php";
require_once "app/models/FooterModel.php";
require_once "app/models/SpecialMenuModel.php"; 

$tokenModel = new TokenModel();
$userModel = new UserModel();
$specialMenuModel = new SpecialMenuModel();

if (!isset($_SESSION["mySession"]) && isset($_COOKIE["usernameEmail"])) {
    $token = $_COOKIE["usernameEmail"];
    if ($tokenModel->checkTokenExists($token)) {
        $user = $userModel->getUserByToken($token);
        if ($user) {
            $_SESSION["mySession"] = $user["Username"];
        }
    }
}
if (!isset($_SESSION["mySession"]) || (isset($_SESSION["mySession"]) && ($_SESSION["mySession"] != "admin" && $_SESSION["mySession"] != "admin@gmail.com"))) {
    header("Location: /webprogramming_assignment_242/");
}


function uploadImage($file)
{
    $target_dir = "uploads/special_menu/";
    
    
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }
    
    $fileName = basename($file["name"]);
    $imageFileType = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
    $newFileName = uniqid() . "." . $imageFileType;
    $target_file = $target_dir . $newFileName;
    
  
    $check = getimagesize($file["tmp_name"]);
    if ($check === false) {
        return ["success" => false, "message" => "File is not an image."];
    }
    
 
    if ($file["size"] > 5000000) {
        return ["success" => false, "message" => "File is too large. Maximum size is 5MB."];
    }
    
    
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        return ["success" => false, "message" => "Only JPG, JPEG, PNG & GIF files are allowed."];
    }
    
   
    if (move_uploaded_file($file["tmp_name"], $target_file)) {
        return ["success" => true, "file_path" => $target_file];
    } else {
        return ["success" => false, "message" => "Error uploading file."];
    }
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
  
    if (isset($_POST["add_menu_item"])) {
       
        if (isset($_FILES["menu_image"]) && $_FILES["menu_image"]["error"] == 0 && !empty($_POST["menu_title"])) {
            $upload_result = uploadImage($_FILES["menu_image"]);
            
            if ($upload_result["success"]) {
                $image_path = $upload_result["file_path"];
                $title = $_POST["menu_title"];
                
                if ($specialMenuModel->addMenuItem($image_path, $title)) {
                    $_SESSION["success_message"] = "Menu item added successfully!";
                } else {
                    $_SESSION["error_message"] = "Failed to add menu item to database.";
                   
                    if (file_exists($image_path)) {
                        @unlink($image_path);
                    }
                }
            } else {
                $_SESSION["error_message"] = $upload_result["message"];
            }
        } else {
            $_SESSION["error_message"] = "Please select an image and enter a title.";
        }
    }
    
   
    if (isset($_POST["edit_menu_item"])) {
        $item_id = $_POST["item_id"];
        $title = $_POST["menu_title"];
        
        $menuItem = $specialMenuModel->getMenuItemById($item_id);
        
        if (!$menuItem) {
            $_SESSION["error_message"] = "Menu item not found.";
        } else {
            $image_path = $menuItem["image_path"]; 
            
          
            if (isset($_FILES["menu_image"]) && $_FILES["menu_image"]["error"] == 0) {
                $upload_result = uploadImage($_FILES["menu_image"]);
                
                if ($upload_result["success"]) {
                  
                    if (file_exists($image_path) && strpos($image_path, 'default') === false) {
                        @unlink($image_path);
                    }
                    
                    $image_path = $upload_result["file_path"];
                } else {
                    $_SESSION["error_message"] = $upload_result["message"];
                    header("Location: /webprogramming_assignment_242/admin/sm");
                    exit();
                }
            }
            
            if ($specialMenuModel->updateMenuItem($item_id, $image_path, $title)) {
                $_SESSION["success_message"] = "Menu item updated successfully!";
            } else {
                $_SESSION["error_message"] = "Failed to update menu item.";
            }
        }
    }
    
 
    if (isset($_POST["delete_menu_item"])) {
        $item_id = $_POST["item_id"];
        
        if ($specialMenuModel->deleteMenuItem($item_id)) {
            $_SESSION["success_message"] = "Menu item deleted successfully!";
        } else {
            $_SESSION["error_message"] = "Failed to delete menu item.";
        }
    }
    
    
    if (isset($_POST["delete_all"])) {
        if ($specialMenuModel->deleteAllMenuItems()) {
            $_SESSION["success_message"] = "All menu items deleted successfully!";
        } else {
            $_SESSION["error_message"] = "Failed to delete all menu items.";
        }
    }
    
   
    header("Location: /webprogramming_assignment_242/admin/sm");
    exit();
}


$menuItems = $specialMenuModel->getAllMenuItems();
$itemCount = $specialMenuModel->getMenuItemCount();

if (isset($_SESSION["success_message"])) {
    echo '<script>alert("' . $_SESSION['success_message'] . '");</script>';
    unset($_SESSION['success_message']);
}

if (isset($_SESSION["error_message"])) {
    echo '<script>alert("' . $_SESSION['error_message'] . '");</script>';
    unset($_SESSION['error_message']);
}

require_once "app/database/database.php";
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Special Menu Management - Admin Dashboard</title>

    <base href="/webprogramming_assignment_242/">
    <!-- bắt buộc phải có dòng này -->

    <link rel="shortcut icon" href="assets/compiled/svg/favicon.svg" type="image/x-icon" />
 
    <link rel="stylesheet" href="assets/extensions/simple-datatables/style.css" />
    <link rel="stylesheet" href="assets/compiled/css/table-datatable.css" />
    <link rel="stylesheet" href="assets/compiled/css/app.css" />
    <link rel="stylesheet" href="assets/compiled/css/app-dark.css" />
    
    <style>
        .menu-image-preview {
            max-width: 100px;
            max-height: 100px;
            object-fit: cover;
        }
        
        .text-danger {
            color: #dc3545;
        }
    </style>
</head>

<body>
    <script src="assets/static/js/initTheme.js"></script>
    <div id="app">

        <?php
        require_once "assets/components/admin/sidebar.php"
        ?>

        <div id="main">

            <?php
            require_once "assets/components/admin/header.php"
            ?>

            <div class="page-heading">
                <div class="page-title">
                    <div class="row">
                        <div class="col-12 col-md-6 order-md-1 order-last">
                            <h3>Special Menu Management</h3>
                            <p class="text-subtitle text-muted">Add and manage special menu items</p>
                        </div>
                    </div>
                </div>
                <section class="section">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4 class="card-title">Special Menu Items (<?php echo $itemCount; ?>)</h4>
                            <div>
                                <?php if ($itemCount > 0): ?>
                                <form method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete ALL menu items?');">
                                    <button type="submit" class="btn btn-danger" name="delete_all">Delete All Items</button>
                                </form>
                                <?php endif; ?>
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addMenuItemModal">
                                    Add Menu Item
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <?php if (empty($menuItems)): ?>
                            <div class="alert alert-info">
                                No menu items have been added yet. Use the "Add Menu Item" button to add special menu items.
                            </div>
                            <?php else: ?>
                            <div class="table-responsive">
                                <table class="table table-striped" id="menu-items-table">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Image</th>
                                            <th>Title</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($menuItems as $item): ?>
                                        <tr>
                                            <td><?php echo $item['id']; ?></td>
                                            <td>
                                                <img src="<?php echo htmlspecialchars($item['image_path']); ?>" 
                                                     alt="<?php echo htmlspecialchars($item['title']); ?>" 
                                                     class="menu-image-preview">
                                            </td>
                                            <td><?php echo htmlspecialchars($item['title']); ?></td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-primary" 
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#editMenuItemModal" 
                                                        data-item-id="<?php echo $item['id']; ?>"
                                                        data-item-title="<?php echo htmlspecialchars($item['title']); ?>"
                                                        data-item-img="<?php echo htmlspecialchars($item['image_path']); ?>">
                                                    Edit
                                                </button>
                                                <form method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this menu item?');">
                                                    <input type="hidden" name="item_id" value="<?php echo $item['id']; ?>">
                                                    <button type="submit" class="btn btn-sm btn-danger" name="delete_menu_item">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </section>
            </div>

          
<div class="modal fade" id="addMenuItemModal" tabindex="-1" aria-labelledby="addMenuItemModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addMenuItemModalLabel">Add New Special Menu Item</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="menu_image" class="form-label">Menu Image</label>
                        <input type="file" class="form-control" id="menu_image" name="menu_image" accept="image/*" required>
                        <small class="text-muted">Accepted formats: JPG, JPEG, PNG, GIF (Max size: 5MB)</small>
                    </div>
                    <div class="mb-3">
                        <label for="menu_title" class="form-label">Menu Title</label>
                        <input type="text" class="form-control" id="menu_title" name="menu_title" placeholder="Enter menu item title" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" name="add_menu_item">Add Menu Item</button>
                </div>
            </form>
        </div>
    </div>
</div>


<div class="modal fade" id="editMenuItemModal" tabindex="-1" aria-labelledby="editMenuItemModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editMenuItemModalLabel">Edit Special Menu Item</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="hidden" id="edit_item_id" name="item_id">
                    <div class="mb-3">
                        <label class="form-label">Current Image</label>
                        <div class="text-center">
                            <img id="current_menu_image" src="" alt="Current menu image" class="img-fluid mb-2" style="max-height: 200px;">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="edit_menu_image" class="form-label">New Menu Image (Optional)</label>
                        <input type="file" class="form-control" id="edit_menu_image" name="menu_image" accept="image/*">
                        <small class="text-muted">Leave empty to keep current image</small>
                    </div>
                    <div class="mb-3">
                        <label for="edit_menu_title" class="form-label">Menu Title</label>
                        <input type="text" class="form-control" id="edit_menu_title" name="menu_title" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" name="edit_menu_item">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>


<script src="assets/static/js/components/dark.js"></script>
     <script src="assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js"></script>

     <script src="assets/compiled/js/app.js"></script>

     <script src="assets/extensions/apexcharts/apexcharts.min.js"></script>
     <script src="assets/static/js/pages/dashboard.js"></script>

<script>
    
    document.addEventListener('DOMContentLoaded', function() {
      
        const editMenuItemModal = document.getElementById('editMenuItemModal');
        if (editMenuItemModal) {
            editMenuItemModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                const itemId = button.getAttribute('data-item-id');
                const itemTitle = button.getAttribute('data-item-title');
                const itemImg = button.getAttribute('data-item-img');
                
                document.getElementById('edit_item_id').value = itemId;
                document.getElementById('edit_menu_title').value = itemTitle;
                document.getElementById('current_menu_image').src = itemImg;
            });
        }
        
     
        const menuImageInput = document.getElementById('menu_image');
        if (menuImageInput) {
            menuImageInput.addEventListener('change', function() {
                if (this.files && this.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                  
                    }
                    reader.readAsDataURL(this.files[0]);
                }
            });
        }
        
      
        const editMenuImageInput = document.getElementById('edit_menu_image');
        if (editMenuImageInput) {
            editMenuImageInput.addEventListener('change', function() {
                if (this.files && this.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        document.getElementById('current_menu_image').src = e.target.result;
                    }
                    reader.readAsDataURL(this.files[0]);
                }
            });
        }
    });
</script>

</div>
</body>

</html>