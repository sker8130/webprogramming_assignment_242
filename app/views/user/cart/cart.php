<!-- trang giỏ hàng, đăng nhập với tài khoản member mới được vào -->


<?php
session_start();
?>

<?php
//nếu session hết hạn nhưng cookie còn -> đặt lại session
//nếu k có session or có mà session là admin -> header tới login
require_once "app/models/UserModel.php";
require_once "app/models/TokenModel.php";

$userModel = new UserModel();
$tokenModel = new TokenModel();
if (!isset($_SESSION["mySession"]) && isset($_COOKIE["usernameEmail"])) {
    $token = $_COOKIE["usernameEmail"];
    if (!$tokenModel->checkTokenExists($token)) {
        $_SESSION["mySession"] = $userModel->getUsernameByToken($token);
    }
}
if (!isset($_SESSION["mySession"]) || (isset($_SESSION["mySession"]) && ($_SESSION["mySession"] == "admin" || $_SESSION["mySession"] == "admin@gmail.com"))):
?>

<div>Please login as a member first!</div>
<br>

<?php else: ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    trang giỏ hàng
</body>

</html>
<?php endif; ?>