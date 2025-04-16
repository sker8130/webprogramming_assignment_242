<!-- trang giỏ hàng -->


<?php
session_start();
?>

<?php if (!isset($_SESSION["mySession"]) || $_SESSION["mySession"] == "admin"): ?>
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