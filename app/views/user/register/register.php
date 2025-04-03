<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Document</title>
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
            <form action="" style="display: flex; flex-flow: column; gap: 10px; width: 100%">
                <h2 style="margin-bottom: -2px">Register</h2>

                <div style="margin-bottom: -2px; font-size: 14px">Name</div>
                <input type="text" style="height: 27px;">

                <div style="margin-bottom: -2px; font-size: 14px">Username</div>
                <input type="text" style="height: 27px;">

                <div style="margin-bottom: -2px; font-size: 14px">Email</div>
                <input type="email" style="height: 27px;">

                <div style="margin-bottom: -2px; font-size: 14px">Password</div>
                <input type="password" style="height: 27px;">

                <div style="margin-bottom: -2px; font-size: 14px">Confirm password</div>
                <input type="password" style="height: 27px;">

                <input type="submit" value="Register"
                    style="width: 35%; height: 33px; color: white; background-color: #2a435d; ">
                <div>I already have an account. <span style="color: #2a435d; font-size: 16px; font-weight: 500">Log
                        in</span>
                </div>
            </form>
        </div>

        <div class="potato-icon">
            <img src="assets/potatochip.png" alt="">
        </div>
    </div>
</body>



</html>