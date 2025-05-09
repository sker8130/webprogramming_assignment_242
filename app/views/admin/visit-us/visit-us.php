<?php
session_start();

//nếu session hết hạn nhưng cookie còn -> đặt lại session
//nếu k có session or có mà session khác admin -> header tới login
require_once "app/models/UserModel.php";
require_once "app/models/TokenModel.php";
require_once "app/models/FooterModel.php";
require_once "app/models/VisitUsModel.php"; 

$tokenModel = new TokenModel();
$userModel = new UserModel(); 
$visitUsModel = new VisitUsModel(); 

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

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["update_visit_us"])) {
    $address = $_POST["address"];
    $phone = $_POST["phone"];
    $email = $_POST["email"];
    $working_hours = $_POST["working_hours"];
    $dphone = $_POST["dphone"];
    
    if ($visitUsModel->updateVisitUsData($address, $phone, $email, $working_hours, $dphone)) {
        $_SESSION["success_message"] = "Visit Us information updated successfully!";
    } else {
        $_SESSION["error_message"] = "Failed to update Visit Us information.";
    }
    
 
    header("Location: /webprogramming_assignment_242/admin/vu");
    exit();
}


$visitUsData = $visitUsModel->getVisitUsData();

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
    <title>Visit Us Management - Admin Dashboard</title>

    <base href="/webprogramming_assignment_242/">
    <!-- bắt buộc phải có dòng này -->

    <link rel="shortcut icon" href="assets/compiled/svg/favicon.svg" type="image/x-icon" />
 
    <link rel="stylesheet" href="assets/extensions/simple-datatables/style.css" />
    <link rel="stylesheet" href="assets/compiled/css/table-datatable.css" />
    <link rel="stylesheet" href="assets/compiled/css/app.css" />
    <link rel="stylesheet" href="assets/compiled/css/app-dark.css" />
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
                            <h3>Visit Us Management</h3>
                        </div>
                    </div>
                </div>
                <section class="section">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Update Visit Us Information</h4>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="address">Address</label>
                                            <input type="text" class="form-control" id="address" name="address" value="<?php echo isset($visitUsData['address']) ? htmlspecialchars($visitUsData['address']) : ''; ?>" required>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="phone">Phone</label>
                                            <input type="text" class="form-control" id="phone" name="phone" value="<?php echo isset($visitUsData['phone']) ? htmlspecialchars($visitUsData['phone']) : ''; ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="phone">Delivery Phone</label>
                                            <input type="text" class="form-control" id="dphone" name="dphone" value="<?php echo isset($visitUsData['dphone']) ? htmlspecialchars($visitUsData['dphone']) : ''; ?>" required>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="email">Email</label>
                                            <input type="email" class="form-control" id="email" name="email" value="<?php echo isset($visitUsData['email']) ? htmlspecialchars($visitUsData['email']) : ''; ?>" required>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="working_hours">Working Hours Description</label>
                                            <textarea class="form-control" id="working_hours" name="working_hours" rows="3" required><?php echo isset($visitUsData['working_hours_description']) ? htmlspecialchars($visitUsData['working_hours_description']) : ''; ?></textarea>
                                            <small class="text-muted">E.g., Monday-Friday: 9AM-5PM, Saturday: 10AM-3PM</small>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-12 d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary me-1 mb-1" name="update_visit_us">Update Information</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Current Visit Us Information</h4>
                        </div>
                        <div class="card-body">
                            <?php if ($visitUsData): ?>
                            <div class="table-responsive">
                                <table class="table table-bordered mb-0">
                                    <tr>
                                        <th>Address</th>
                                        <td><?php echo htmlspecialchars($visitUsData['address']); ?></td>
                                    </tr>
                                    <tr>
                                        <th>Phone</th>
                                        <td><?php echo htmlspecialchars($visitUsData['phone']); ?></td>
                                    </tr>
                                    <tr>
                                        <th>Delivery Phone</th>
                                        <td><?php echo htmlspecialchars($visitUsData['dphone']); ?></td>
                                    </tr>
                                    <tr>
                                        <th>Email</th>
                                        <td><?php echo htmlspecialchars($visitUsData['email']); ?></td>
                                    </tr>
                                    <tr>
                                        <th>Working Hours</th>
                                        <td><?php echo nl2br(htmlspecialchars($visitUsData['working_hours_description'])); ?></td>
                                    </tr>
                                </table>
                            </div>
                            <?php else: ?>
                            <p>No visit us information found. Please add information using the form above.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </section>
            </div>

            <footer>
                <div class="footer clearfix mb-0 text-muted">
                    <div class="float-start">
                        <p>2023 &copy; Mazer</p>
                    </div>
                    <div class="float-end">
                        <p>
                            Crafted with
                            <span class="text-danger"><i class="bi bi-heart-fill icon-mid"></i></span>
                            by <a href="https://saugi.me">Saugi</a>
                        </p>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="assets/static/js/components/dark.js"></script>
    <script src="assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js"></script>

    <script src="assets/compiled/js/app.js"></script>

    <script src="assets/extensions/simple-datatables/umd/simple-datatables.js"></script>
    <script src="assets/static/js/pages/simple-datatables.js"></script>
</body>

</html>