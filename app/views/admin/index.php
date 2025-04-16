<!-- trang chủ admin -->

<?php
session_start();
if (isset($_SESSION['success_message'])) {
    echo '<script>alert("' . $_SESSION['success_message'] . '");</script>';
    unset($_SESSION['success_message']);
}
?>

<?php if (!isset($_SESSION["mySession"]) || $_SESSION["mySession"] != "admin"): ?>

<div>Please login as the admin first!</div>
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
    trang chủ admin
</body>

</html>
<?php endif; ?>