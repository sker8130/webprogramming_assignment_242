<?php
session_start();

//nếu session hết hạn nhưng cookie còn -> đặt lại session
//nếu k có session or có mà session khác admin -> header tới login
require_once "app/models/UserModel.php";
require_once "app/models/TokenModel.php";
require_once "app/models/FooterModel.php";
require_once "app/models/PopularDishesModel.php"; 

$tokenModel = new TokenModel();
$userModel = new UserModel();
$popularDishesModel = new PopularDishesModel();

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
    $target_dir = "uploads/popular_dishes/";
    
    
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
  
    if (isset($_POST["add_dish"])) {
       
        if ($popularDishesModel->getDishCount() >= 5) {
            $_SESSION["error_message"] = "Maximum limit of 5 dishes reached. Delete some dishes first.";
        } else {
          
            if (isset($_FILES["dish_image"]) && $_FILES["dish_image"]["error"] == 0) {
                $upload_result = uploadImage($_FILES["dish_image"]);
                
                if ($upload_result["success"]) {
                    $image_path = $upload_result["file_path"];
                    $alt_text = $_POST["alt_text"];
                    
                    if ($popularDishesModel->addDish($image_path, $alt_text)) {
                        $_SESSION["success_message"] = "Dish added successfully!";
                    } else {
                        $_SESSION["error_message"] = "Failed to add dish to database.";
                       
                        if (file_exists($image_path)) {
                            @unlink($image_path);
                        }
                    }
                } else {
                    $_SESSION["error_message"] = $upload_result["message"];
                }
            } else {
                $_SESSION["error_message"] = "Please select an image to upload.";
            }
        }
    }
    
   
    if (isset($_POST["edit_dish"])) {
        $dish_id = $_POST["dish_id"];
        $alt_text = $_POST["alt_text"];
        
        $dish = $popularDishesModel->getDishById($dish_id);
        
        if (!$dish) {
            $_SESSION["error_message"] = "Dish not found.";
        } else {
            $image_path = $dish["image_path"]; 
            
          
            if (isset($_FILES["dish_image"]) && $_FILES["dish_image"]["error"] == 0) {
                $upload_result = uploadImage($_FILES["dish_image"]);
                
                if ($upload_result["success"]) {
                  
                    if (file_exists($image_path) && strpos($image_path, 'default') === false) {
                        @unlink($image_path);
                    }
                    
                    $image_path = $upload_result["file_path"];
                } else {
                    $_SESSION["error_message"] = $upload_result["message"];
                    header("Location: /webprogramming_assignment_242/admin/pd");
                    exit();
                }
            }
            
            if ($popularDishesModel->updateDish($dish_id, $image_path, $alt_text)) {
                $_SESSION["success_message"] = "Dish updated successfully!";
            } else {
                $_SESSION["error_message"] = "Failed to update dish.";
            }
        }
    }
    
 
    if (isset($_POST["delete_dish"])) {
        $dish_id = $_POST["dish_id"];
        
        if ($popularDishesModel->deleteDish($dish_id)) {
            
            $popularDishesModel->reorderDishes();
            $_SESSION["success_message"] = "Dish deleted successfully!";
        } else {
            $_SESSION["error_message"] = "Failed to delete dish.";
        }
    }
    
    
    if (isset($_POST["delete_all"])) {
        if ($popularDishesModel->deleteAllDishes()) {
            $_SESSION["success_message"] = "All dishes deleted successfully!";
        } else {
            $_SESSION["error_message"] = "Failed to delete all dishes.";
        }
    }
    
   
    header("Location: /webprogramming_assignment_242/admin/pd");
    exit();
}


$dishes = $popularDishesModel->getAllDishes();
$dishCount = $popularDishesModel->getDishCount();

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
    <title>Popular Dishes Management - Admin Dashboard</title>

    <base href="/webprogramming_assignment_242/">
    <!-- bắt buộc phải có dòng này -->

    <link rel="shortcut icon" href="assets/compiled/svg/favicon.svg" type="image/x-icon" />
 
    <link rel="stylesheet" href="assets/extensions/simple-datatables/style.css" />
    <link rel="stylesheet" href="assets/compiled/css/table-datatable.css" />
    <link rel="stylesheet" href="assets/compiled/css/app.css" />
    <link rel="stylesheet" href="assets/compiled/css/app-dark.css" />
    
    <style>
        .dish-image-preview {
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
                            <h3>Popular Dishes Management</h3>
                            <p class="text-subtitle text-muted">Add and manage up to 5 popular dish images</p>
                        </div>
                    </div>
                </div>
                <section class="section">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4 class="card-title">Popular Dishes (<?php echo $dishCount; ?>/5)</h4>
                            <div>
                                <?php if ($dishCount > 0): ?>
                                <form method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete ALL dishes?');">
                                    <button type="submit" class="btn btn-danger" name="delete_all">Delete All Dishes</button>
                                </form>
                                <?php endif; ?>
                                <?php if ($dishCount < 5): ?>
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addDishModal">
                                    Add Dish
                                </button>
                                <?php else: ?>
                                <button type="button" class="btn btn-primary" disabled title="Maximum of 5 dishes reached">
                                    Add Dish
                                </button>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="card-body">
                            <?php if (empty($dishes)): ?>
                            <div class="alert alert-info">
                                No dishes have been added yet. Use the "Add Dish" button to add up to 5 popular dishes.
                            </div>
                            <?php else: ?>
                            <div class="table-responsive">
                                <table class="table table-striped" id="dishes-table">
                                    <thead>
                                        <tr>
                                            <th>Order</th>
                                            <th>Image</th>
                                            <th>Alt Text</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($dishes as $dish): ?>
                                        <tr>
                                            <td><?php echo $dish['dish_order']; ?></td>
                                            <td>
                                                <img src="<?php echo htmlspecialchars($dish['image_path']); ?>" 
                                                     alt="<?php echo htmlspecialchars($dish['alt_text']); ?>" 
                                                     class="dish-image-preview">
                                            </td>
                                            <td><?php echo htmlspecialchars($dish['alt_text']); ?></td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-primary" 
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#editDishModal" 
                                                        data-dish-id="<?php echo $dish['id']; ?>"
                                                        data-dish-alt="<?php echo htmlspecialchars($dish['alt_text']); ?>"
                                                        data-dish-img="<?php echo htmlspecialchars($dish['image_path']); ?>">
                                                    Edit
                                                </button>
                                                <form method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this dish?');">
                                                    <input type="hidden" name="dish_id" value="<?php echo $dish['id']; ?>">
                                                    <button type="submit" class="btn btn-sm btn-danger" name="delete_dish">Delete</button>
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

          
<div class="modal fade" id="addDishModal" tabindex="-1" aria-labelledby="addDishModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addDishModalLabel">Add New Popular Dish</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="dish_image" class="form-label">Dish Image</label>
                        <input type="file" class="form-control" id="dish_image" name="dish_image" accept="image/*" required>
                        <small class="text-muted">Accepted formats: JPG, JPEG, PNG, GIF (Max size: 5MB)</small>
                    </div>
                    <div class="mb-3">
                        <label for="alt_text" class="form-label">Alt Text</label>
                        <input type="text" class="form-control" id="alt_text" name="alt_text" placeholder="Describe the dish" required>
                        <small class="text-muted">Short description of the dish for accessibility</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" name="add_dish">Add Dish</button>
                </div>
            </form>
        </div>
    </div>
</div>


<div class="modal fade" id="editDishModal" tabindex="-1" aria-labelledby="editDishModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editDishModalLabel">Edit Popular Dish</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="hidden" id="edit_dish_id" name="dish_id">
                    <div class="mb-3">
                        <label class="form-label">Current Image</label>
                        <div class="text-center">
                            <img id="current_dish_image" src="" alt="Current dish image" class="img-fluid mb-2" style="max-height: 200px;">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="edit_dish_image" class="form-label">New Dish Image (Optional)</label>
                        <input type="file" class="form-control" id="edit_dish_image" name="dish_image" accept="image/*">
                        <small class="text-muted">Leave empty to keep current image</small>
                    </div>
                    <div class="mb-3">
                        <label for="edit_alt_text" class="form-label">Alt Text</label>
                        <input type="text" class="form-control" id="edit_alt_text" name="alt_text" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" name="edit_dish">Save Changes</button>
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
      
        const editDishModal = document.getElementById('editDishModal');
        if (editDishModal) {
            editDishModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                const dishId = button.getAttribute('data-dish-id');
                const dishAlt = button.getAttribute('data-dish-alt');
                const dishImg = button.getAttribute('data-dish-img');
                
                document.getElementById('edit_dish_id').value = dishId;
                document.getElementById('edit_alt_text').value = dishAlt;
                document.getElementById('current_dish_image').src = dishImg;
            });
        }
        
     
        const dishImageInput = document.getElementById('dish_image');
        if (dishImageInput) {
            dishImageInput.addEventListener('change', function() {
                if (this.files && this.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                   
                    }
                    reader.readAsDataURL(this.files[0]);
                }
            });
        }
        
      
        const editDishImageInput = document.getElementById('edit_dish_image');
        if (editDishImageInput) {
            editDishImageInput.addEventListener('change', function() {
                if (this.files && this.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        document.getElementById('current_dish_image').src = e.target.result;
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