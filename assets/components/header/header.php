<!-- header component -->
<?php
//header
session_start();
// if (isset($_GET['logout'])) {
//     session_unset();
//     session_destroy();
//     header("Location: /webprogramming_assignment_242");
//     exit();
// }
require_once "app/models/HeaderModel.php";
$headerModel = new HeaderModel();
$currentLogo = $headerModel->getLogo();
?>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="assets/components/style.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Arvo:ital,wght@0,400;0,700;1,400;1,700&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet" />
    <title>Header restaurant</title>
</head>

<header>
    <div class="logo">
        <a href="#">
        <img src="<?php echo $currentLogo; ?>" alt="Current Logo" style="max-width: 200px; max-height: 86px;">
        </a>
    </div>
    <nav>
        <ul class="nav-links">
            <li><a href="/webprogramming_assignment_242">HOME</a></li>
            <li><a href="/webprogramming_assignment_242/introduction">ABOUT</a></li> 
            <li><a href="/webprogramming_assignment_242/items">ITEMS</a></li>
            <li><a href="/webprogramming_assignment_242/blogs">BLOGS</a></li>
            <li><a href="/webprogramming_assignment_242/contact">CONTACT</a></li>
        </ul>
        <img src="assets/components/images/icon-hamburger.png" class="hamburger" id="hamburger" alt="Menu" />
    </nav>
    <div class="header-right">
        <div class="image">
            <img src="assets/components/images/icon-delivery.png" alt="icon delivery" />
        </div>
        <?php
        //nếu session hết hạn nhưng cookie còn -> đặt lại session
        //nếu k có session or có mà session là admin -> header tới login
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

    

        //kiểm tra chưa đăng nhập
        $notLoginCond = !isset($_SESSION["mySession"]) || (isset($_SESSION["mySession"]) && ($_SESSION["mySession"] == "admin" || $_SESSION["mySession"] == "admin@gmail.com"));

        if (!$notLoginCond):
            try {
                $pdo = new PDO("mysql:host=localhost;dbname=restaurant", "root", "");
                $avatar = $pdo->query("SELECT Avatar FROM users WHERE Username = '" . $_SESSION['mySession'] . "'")->fetchColumn();
            } catch (PDOException $e) {
                $avatar = 'assets/default-pfp.png';
            }
        ?>
        <a href="profile.php" class="avatar-container"
            style="display: block; width: 80px; height: 80px; border-radius: 50%; overflow: hidden;">
            <img src="<?php echo htmlspecialchars($avatar); ?>" alt="User Avatar"
                style="width: 100%; height: 100%; object-fit: cover;" onerror="this.src='assets/default-pfp.png'">
        </a>
        <a class="cart" href="cart.php">
            <img src="assets/components/images/cart.png" alt="icon cart" />
        </a>
        <!-- <a href="?logout=true" type="button" class="btn btn-primary btn-login btn-logout">Log Out</a> -->
        <a type="button" class="btn btn-primary btn-login btn-logout" onclick="confirmLogout()">Log Out</a>
        <?php else: ?>
        <a type="button" class="btn btn-primary btn-login" href="/webprogramming_assignment_242/login">
            <span>Login</span>
        </a>
        <?php endif; ?>
    </div>
    <script src="assets/components/header-script.js"></script>
</header>