<?php
// session_start(); 
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Register</title>
    <link rel="stylesheet" href="app/views/user/register/register.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
</head>

<body>
    <div class="container">
        <div class="main-register">
            <form action="" onsubmit="return registerForm()" method="post">
                <h2 style="margin-bottom: -2px">Register</h2>

                <!-- hiện message: -->
                <div id="message">
                    <?php
                    if (isset($errors["message"])) {
                        echo $errors["message"];
                    }
                    ?>
                </div>

                <div class="register-input">Username</div>
                <input type="text" id="username" name="username"
                    value="<?php echo isset($oldInput["username"]) ? htmlspecialchars($oldInput["username"]) : ""; ?>">

                <div class="register-input">Email</div>
                <input type="email" id="email" name="email"
                    value="<?php echo isset($oldInput["email"]) ? htmlspecialchars($oldInput["email"]) : ""; ?>">

                <div class="register-input">Phone Number</div>
                <input type="tel" id="phoneNumber" name="phoneNumber" pattern="[0-9]{10}" placeholder="1234567890"
                    value="<?php echo isset($oldInput["phoneNumber"]) ? htmlspecialchars($oldInput["phoneNumber"]) : ""; ?>">

                <div class="register-input">Gender</div>
                <select id="gender" name="gender">
                    <option value="female"
                        <?php echo (isset($oldInput["gender"]) && $oldInput["gender"] === "female") ? "selected" : ""; ?>>
                        Female</option>
                    <option value="male"
                        <?php echo (isset($oldInput["gender"]) && $oldInput["gender"] === "male") ? "selected" : ""; ?>>
                        Male</option>
                    <option value="other"
                        <?php echo (isset($oldInput["gender"]) && $oldInput["gender"] === "other") ? "selected" : ""; ?>>
                        Other</option>
                </select>

                <div class="register-input">Date of Birth</div>
                <input type="date" id="dob" name="dob"
                    value="<?php echo isset($oldInput["dob"]) ? htmlspecialchars($oldInput["dob"]) : ""; ?>">

                <div class="register-input">Password</div>
                <input type="password" id="password" name="password"
                    value="<?php echo isset($oldInput["password"]) ? htmlspecialchars($oldInput["password"]) : ""; ?>">

                <div class="register-input">Confirm Password</div>
                <input type="password" id="confirmedPassword" name="confirmedPassword"
                    value="<?php echo isset($oldInput["confirmedPassword"]) ? htmlspecialchars($oldInput["confirmedPassword"]) : ""; ?>">

                <input type="submit" value="Register">
                <div>I already have an account. <span><a href="/webprogramming_assignment_242/login">
                            Log in</a></span>
                </div>
            </form>
        </div>

        <div class="potato-icon">
            <img src="assets/components/images/potatochip.png" alt="potato icon">
        </div>
    </div>
</body>

</html>

<script>
function registerForm() {
    // e.preventDefault();

    let username = document.getElementById("username").value;
    let email = document.getElementById("email").value;
    let phoneNumber = document.getElementById("phoneNumber").value;
    let gender = document.getElementById("gender").value;
    let dob = document.getElementById("dob").value;
    let password = document.getElementById("password").value;
    let confirmedPassword = document.getElementById("confirmedPassword").value;
    // const regex = /^(?=.*[a-zA-Z])(?=.*[0-9]).+$/;
    const regex = /^(?=.*[a-zA-Z])(?=.*[0-9])[a-zA-Z0-9]+$/;


    if (username.length == 0 || email.length == 0 || phoneNumber.length == 0 || gender.length == 0 || dob.length == 0 ||
        password.length == 0 || confirmedPassword.length == 0) {
        document.getElementById("message").innerText =
            "** Please type full information! **";
        return false;
    } else {
        if (username.length < 2 || username.length > 30 || !regex.test(username)) {
            document.getElementById("message").innerText =
                "** Username must be from 2 to 30 characters long, including numbers and no special characters, please type again! ** ";
            return false;
        } else if (Number(dob.substring(0, 4)) > 2010) {
            document.getElementById("message").innerText = "** Age must be over 15, please type again! **";
            return false;
        } else if (password.length < 12 || !/\d/.test(password)) {
            document.getElementById("message").innerText =
                "** Password must be at least 12 characters, including numbers, please type again! ** ";
            return false;
        } else if (password != confirmedPassword) {
            document.getElementById("message").innerText =
                "** Password and confirmed password must match, please type again! **";
            return false;
        } else {
            document.getElementById("message").innerText = "";
            return true;
        }
    }
}
</script>