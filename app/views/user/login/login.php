<?php
session_start();
if (isset($_SESSION['success_message'])) {
    echo '<script>alert("' . $_SESSION['success_message'] . '");</script>';
    unset($_SESSION['success_message']);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Document</title>
    <link rel="stylesheet" href="app/views/user/login/login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
</head>

<body>
    <div class="container">
        <div class="main-login">
            <form action="" style="display: flex; flex-flow: column; gap: 10px; width: 100%" method="post">
                <h2 style="margin-bottom: -2px">Login</h2>

                <div style="margin-bottom: -2px; font-size: 16px; color: yellow">
                    <?php
                    if (isset($errors["message"])) {
                        echo $errors["message"];
                    }
                    ?>
                </div>

                <div style="margin-bottom: -2px; font-size: 14px">Username or email address *</div>
                <input type="text" name="usernameEmail"
                    value="<?php echo isset($oldInput["usernameEmail"]) ? htmlspecialchars($oldInput["usernameEmail"]) : ""; ?>">
                <div style="margin-bottom: -2px; font-size: 14px">Password *</div>
                <input type="password" name="password"
                    value="<?php echo isset($oldInput["password"]) ? htmlspecialchars($oldInput["password"]) : ""; ?>">
                <input type="submit" value="Log in"
                    style="width: 35%; height: 33px; color: white; background-color: #2a435d; ">
                <label style="color: #2a435d; display: flex; align-items: center; gap: 4px">
                    <input type="checkbox" name="remember">
                    <div>Remember me</div>
                </label>
                <div style="color: #4BFF3C">Lost your password</div>
                <div>Don't have an account? <span style="color: #2a435d; font-size: 16px; font-weight: 500"><a
                            href="/webprogramming_assignment_242/register">Register</a></span>
                </div>
            </form>
        </div>
        <div class="potato-icon">
            <img src="assets/potatochip.png" alt="">
        </div>
    </div>
</body>



</html>