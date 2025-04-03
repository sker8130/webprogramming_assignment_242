<!-- header component -->
<?php
//header
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
            <img src="assets/components/images/logo-img-1.png" alt="logo image" />
        </a>
    </div>
    <nav>
        <ul class="nav-links">
            <li><a href="../index.php">HOME</a></li>
            <li><a href="../about.php">ABOUT</a></li>
            <li><a href="../services.php">ITEMS</a></li>
            <li><a href="../contact.php">PAGES</a></li>
            <li><a href="../contact.php">CONTACT</a></li>
        </ul>
        <img src="assets/components/images/icon-hamburger.png" class="hamburger" id="hamburger" alt="Menu" />
    </nav>
    <div class="header-right">
        <div class="image">
            <img src="assets/components/images/icon-delivery.png" alt="icon delivery" />
        </div>
        <a type="button" class="btn btn-primary btn-login">
            <span>Login</span>
        </a>
    </div>
    <script src="assets/header-script.js"></script>
</header>