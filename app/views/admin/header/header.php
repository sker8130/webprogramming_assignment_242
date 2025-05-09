<?php
session_start();

//nếu session hết hạn nhưng cookie còn -> đặt lại session
//nếu k có session or có mà session khác admin -> header tới login
require_once "app/models/UserModel.php";
require_once "app/models/TokenModel.php";
require_once "app/models/HeaderModel.php";
$headerModel = new HeaderModel();
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["logo"])) {
    $targetDir = "uploads/logos/";


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

                if ($headerModel->updateLogo($targetFilePath)) {
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

  
    header("Location: /webprogramming_assignment_242/admin/header");
    exit();
}
$userModel = new UserModel();
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
$currentLogo = $headerModel->getLogo();

?>






<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>DataTable - Mazer Admin Dashboard</title>

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
                            <h3>Logo Management</h3>
                            <p class="text-subtitle text-muted">Update your website logo</p>
                        </div>
                        <div class="col-12 col-md-6 order-md-2 order-first">
                            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="/webprogramming_assignment_242/admin/dashboard">Dashboard</a></li>
                                    <li class="breadcrumb-item"><a href="/webprogramming_assignment_242/admin/settings">Settings</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Logo</li>
                                </ol>
                            </nav>
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



    <script>
        function deleteConfirm(id) {
            if (confirm(`Delete this comment with ID =  ${id}?`)) {
                window.location.href = `/webprogramming_assignment_242/admin/comments/delete?id=${id}`;
            }
        }
    </script>
</body>

</html>