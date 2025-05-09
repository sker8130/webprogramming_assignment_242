<?php
session_start();

//nếu session hết hạn nhưng cookie còn -> đặt lại session
//nếu k có session or có mà session khác admin -> header tới login
require_once "app/models/UserModel.php";
require_once "app/models/TokenModel.php";

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

if (isset($_SESSION["error_message"])) {
    echo '<script>alert("' . $_SESSION['error_message'] . '");</script>';
    unset($_SESSION['error_message']);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Contact - Admin Dashboard</title>

    <base href="/webprogramming_assignment_242/">
    <!-- bắt buộc phải có dòng này -->

    <link rel="shortcut icon" href="assets/compiled/svg/favicon.svg" type="image/x-icon" />

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
                            <h3>View Contact</h3>
                            <p class="text-subtitle text-muted">Contact details and responses</p>
                        </div>
                        <div class="col-12 col-md-6 order-md-2 order-first">
                            <div class="float-end">
                                <a href="/webprogramming_assignment_242/admin/contact" class="btn btn-primary">
                                    <i class="bi bi-arrow-left"></i> Back to List
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <section class="section">
                    <div class="row">
                        <div class="col-12 col-md-8">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Contact Information</h4>
                                    <div class="card-subtitle">
                                        <span class="badge bg-<?php 
                                            echo $contact['Status'] == 'Unread' ? 'danger' : 
                                                ($contact['Status'] == 'Read' ? 'warning' : 'success'); 
                                        ?>">
                                            <?php echo $contact['Status']; ?>
                                        </span>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <p><strong>Contact ID:</strong> <?php echo $contact['ContactID']; ?></p>
                                            <p><strong>Name:</strong> <?php echo $contact['Name']; ?></p>
                                            <p><strong>Email:</strong> <?php echo $contact['Email']; ?></p>
                                        </div>
                                        <div class="col-md-6">
                                            <p><strong>Date:</strong> <?php echo date('F j, Y, g:i a', strtotime($contact['CreatedAt'])); ?></p>
                                            <p><strong>Status:</strong> <?php echo $contact['Status']; ?></p>
                                        </div>
                                    </div>
                                    
                                    <hr>
                                    
                                    <div class="mt-3">
                                        <h5>Message:</h5>
                                        <div class="p-3 bg-light rounded">
                                            <?php echo nl2br(htmlspecialchars($contact['Message'])); ?>
                                        </div>
                                    </div>
                                    
                                    <div class="mt-4">
                                        <div class="d-flex justify-content-end">
                                            <a href="/webprogramming_assignment_242/admin/contact/reply?id=<?php echo $contact['ContactID']; ?>" class="btn btn-primary">
                                                <i class="bi bi-reply"></i> Reply
                                            </a>
                                            <div class="dropdown ms-2">
                                                <button class="btn btn-secondary dropdown-toggle" type="button" id="statusDropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    Change Status
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="statusDropdown">
                                                    <a class="dropdown-item" href="/webprogramming_assignment_242/admin/contact/mark?id=<?php echo $contact['ContactID']; ?>&status=Unread">Mark as Unread</a>
                                                    <a class="dropdown-item" href="/webprogramming_assignment_242/admin/contact/mark?id=<?php echo $contact['ContactID']; ?>&status=Read">Mark as Read</a>
                                                    <a class="dropdown-item" href="/webprogramming_assignment_242/admin/contact/mark?id=<?php echo $contact['ContactID']; ?>&status=Responded">Mark as Responded</a>
                                                </div>
                                            </div>
                                            <a href="#" onclick="deleteConfirm(<?php echo $contact['ContactID']; ?>)" class="btn btn-danger ms-2">
                                                <i class="bi bi-trash"></i> Delete
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-12 col-md-4">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Replies</h4>
                                </div>
                                <div class="card-body">
                                    <?php if (empty($replies)): ?>
                                        <div class="alert alert-info">
                                            No replies yet.
                                        </div>
                                    <?php else: ?>
                                        <div class="replies-list">
                                            <?php foreach ($replies as $reply): ?>
                                                <div class="reply-item border-bottom pb-3 mb-3">
                                                    <div class="reply-content p-3 bg-light rounded">
                                                        <?php echo nl2br(htmlspecialchars($reply['ReplyMessage'])); ?>
                                                    </div>
                                                    <div class="reply-footer mt-2 text-end">
                                                        <small class="text-muted">
                                                            <?php echo date('F j, Y, g:i a', strtotime($reply['CreatedAt'])); ?>
                                                        </small>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <div class="mt-3">
                                        <a href="/webprogramming_assignment_242/admin/contact/reply?id=<?php echo $contact['ContactID']; ?>" class="btn btn-primary btn-block">
                                            <i class="bi bi-reply"></i> Add Reply
                                        </a>
                                    </div>
                                </div>
                            </div>
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

    <script>
    function deleteConfirm(id) {
        if (confirm(`Delete this contact with ID = ${id}?`)) {
            window.location.href = `/webprogramming_assignment_242/admin/contact/delete?id=${id}`;
        }
    }
    </script>
</body>
</html>