<?php
session_start();

//nếu session hết hạn nhưng cookie còn -> đặt lại session
//nếu k có session or có mà session khác admin -> header tới login
require_once "app/models/UserModel.php";
require_once "app/models/TokenModel.php";
require_once "app/models/FooterModel.php"; 

$footerModel = new FooterModel();
$currentLogo = $footerModel->getLogo();


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["logo"])) {
    $targetDir = "uploads/logosf/";


    if (!file_exists($targetDir)) {
        mkdir($targetDir, 0777, true);
    }

    $fileName = basename($_FILES["logo"]["name"]);
    $targetFilePath = $targetDir . time() . "_" . $fileName;
    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);


    $check = getimagesize($_FILES["logo"]["tmp_name"]);
    if ($check !== false) {

        $allowTypes = array('jpg', 'png', 'jpeg', 'gif', 'svg');
        if (in_array($fileType, $allowTypes)) {

            if (move_uploaded_file($_FILES["logo"]["tmp_name"], $targetFilePath)) {

                if ($footerModel->updateLogo($targetFilePath)) {
                    $_SESSION["success_message"] = "Logo has been updated successfully.";
                } else {
                    $_SESSION["error_message"] = "Failed to update logo in database.";
                }
            } else {
                $_SESSION["error_message"] = "Failed to upload logo to server.";
            }
        } else {
            $_SESSION["error_message"] = "Only JPG, JPEG, PNG, GIF & SVG files are allowed.";
        }
    } else {
        $_SESSION["error_message"] = "Uploaded file is not an image.";
    }

  
    header("Location: /webprogramming_assignment_242/admin/footer");
    exit();
}




$tokenModel = new TokenModel();
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

if (isset($_SESSION["success_message"])) {
    echo '<script>alert("' . $_SESSION['success_message'] . '");</script>';
    unset($_SESSION['success_message']);
}

require_once "app/database/database.php";


$footerModel = new FooterModel();


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["update_footer"])) {
    $working_hour_1 = $_POST["working_hour_1"];
    $working_hour_2 = $_POST["working_hour_2"];
    $phone_1 = $_POST["phone_1"];
    $phone_2 = $_POST["phone_2"];
    $hotline = $_POST["hotline"];
    $copyright= $_POST["copyright"];
    $place_1= $_POST["place_1"];
    $place_2= $_POST["place_2"];
    

    $result = $footerModel->updateFooter($working_hour_1, $working_hour_2, $phone_1, $phone_2, $hotline, $copyright, $place_1, $place_2);
    
    if ($result) {
        $_SESSION["success_message"] = "Footer information updated successfully!";
        header("Location: /webprogramming_assignment_242/admin/footer");
        exit();
    } else {
        $_SESSION["error_message"] = "Failed to update footer information.";
    }
}


$footerInfo = $footerModel->getFooterInfo();
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Footer Management - Admin Dashboard</title>

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
                            <h3>Footer Management</h3>
                        </div>
                    </div>
                </div>

                <section class="section">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Current Logo</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <img src="<?php echo $currentLogo; ?>" alt="Current Logo" style="max-width: 200px; max-height: 100px;">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Upload New Logo</h4>
                        </div>
                        <div class="card-body">
                            <form action="" method="POST" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="logo">Select Logo Image</label>
                                            <input type="file" class="form-control" id="logo" name="logo" required>
                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary me-1 mb-1">Upload Logo</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </section>


                <section class="section">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Modify Footer Information</h4>
                        </div>
                        <div class="card-body">
                            <?php if (isset($_SESSION["error_message"])): ?>
                                <div class="alert alert-danger"><?php echo $_SESSION["error_message"]; unset($_SESSION["error_message"]); ?></div>
                            <?php endif; ?>
                            
                            <form method="POST" action="">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="working_hour_1">Working Hours (Line 1)</label>
                                            <input type="text" class="form-control" id="working_hour_1" name="working_hour_1" 
                                                value="<?php echo isset($footerInfo['working_hour_1']) ? htmlspecialchars($footerInfo['working_hour_1']) : ''; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="working_hour_2">Working Hours (Line 2)</label>
                                            <input type="text" class="form-control" id="working_hour_2" name="working_hour_2" 
                                                value="<?php echo isset($footerInfo['working_hour_2']) ? htmlspecialchars($footerInfo['working_hour_2']) : ''; ?>">
                                        </div>
                                    </div>




                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="place_11">Place 1</label>
                                            <input type="text" class="form-control" id="place_1" name="place_1" 
                                                value="<?php echo isset($footerInfo['place_1']) ? htmlspecialchars($footerInfo['place_1']) : ''; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="place_2">Place 2</label>
                                            <input type="text" class="form-control" id="place_2" name="place_2" 
                                                value="<?php echo isset($footerInfo['place_2']) ? htmlspecialchars($footerInfo['place_2']) : ''; ?>">
                                        </div>
                                    </div>





                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="phone_1">Phone Number 1</label>
                                            <input type="text" class="form-control" id="phone_1" name="phone_1" 
                                                value="<?php echo isset($footerInfo['phone_1']) ? htmlspecialchars($footerInfo['phone_1']) : ''; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="phone_2">Phone Number 2</label>
                                            <input type="text" class="form-control" id="phone_2" name="phone_2" 
                                                value="<?php echo isset($footerInfo['phone_2']) ? htmlspecialchars($footerInfo['phone_2']) : ''; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="hotline">Hotline</label>
                                            <input type="text" class="form-control" id="hotline" name="hotline" 
                                                value="<?php echo isset($footerInfo['hotline']) ? htmlspecialchars($footerInfo['hotline']) : ''; ?>">
                                        </div>

                                        <div class="form-group">
                                            <label for="hotline">Copyright Text</label>
                                            <input type="text" class="form-control" id="copyright" name="copyright" 
                                                value="<?php echo isset($footerInfo['copyright']) ? htmlspecialchars($footerInfo['copyright']) : ''; ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-4">
                                    <div class="col-12 d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary me-1 mb-1" name="update_footer">Save Changes</button>
                                    </div>
                                </div>
                            </form>
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