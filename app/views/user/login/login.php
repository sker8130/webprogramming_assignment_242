<?php
// session_start();
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
    <title>Login</title>
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
            <form action="" method="post">
                <h2>Login</h2>

                <div class="message">
                    <?php
                    if (isset($errors["message"])) {
                        echo $errors["message"];
                    }
                    ?>
                </div>

                <div class="login-input">Username or email address *</div>
                <input type="text" name="usernameEmail"
                    value="<?php echo isset($oldInput["usernameEmail"]) ? htmlspecialchars($oldInput["usernameEmail"]) : ""; ?>">
                <div class="login-input">Password *</div>
                <input type="password" name="password"
                    value="<?php echo isset($oldInput["password"]) ? htmlspecialchars($oldInput["password"]) : ""; ?>">
                <input type="submit" value="Log in">
                <label class="remember-me">
                    <input type="checkbox" name="remember">
                    <div>Remember me</div>
                </label>
                <div>Don't have an account? <span><a href="/webprogramming_assignment_242/register"
                            class="register">Register</a></span>
                </div>
            </form>
        </div>
        <div class="potato-icon">
            <img src="assets/components/images/potatochip.png" alt="potato icon">
        </div>
    </div>
</body>



</html>