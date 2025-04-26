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
            <li><a href="/webprogramming_assignment_242">HOME</a></li>
            <li><a href="/webprogramming_assignment_242/about">ABOUT</a></li>
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
        <a type="button" class="btn btn-primary btn-login" href="/webprogramming_assignment_242/login">
            <span>Login</span>
        </a>
    </div>
    <script src="assets/components/header-script.js"></script>
</header>