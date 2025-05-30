<!-- footer component  -->
<?php
//footer
require_once "app/models/FooterModel.php";
$footerModel = new FooterModel();
$footerInfo = $footerModel->getFooterInfo();
$currentLogo = $footerModel->getLogo();
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
    <title>Footer restaurant</title>
</head>

<footer>
    <div class="">
        <div class="footer-logo">



            <img src="<?php echo $currentLogo; ?>" alt="image logo 2" width="270" height="86" />




        </div>
        <div class="footer-content">
            <div class="branchs">
                <div class="store" id="store1">
                    <div class="address">
                        <span class="icon-location"><img src="assets/components/images/icon-location.png"
                                alt="icon location" /></span>
                        <span><?php echo isset($footerInfo['place_1']) ? htmlspecialchars($footerInfo['place_1']) : ''; ?></span>
                    </div>
                    <div class="store-info">
                        <div class="open-hour">
                            <span><img src="assets/components/images/icon-watch.png" alt="icon watch" /></span>
                            <span><?php echo isset($footerInfo['working_hour_1']) ? htmlspecialchars($footerInfo['working_hour_1']) : ''; ?></span>
                        </div>
                        <div class="phone-num">
                            <span><img src="assets/components/images/icon-phone.png" alt="icon phone" /></span>
                            <span><?php echo isset($footerInfo['phone_1']) ? htmlspecialchars($footerInfo['phone_1']) : ''; ?></span>
                        </div>
                    </div>
                </div>
                <div class="store" id="store2">
                    <div class="address">
                        <span class="icon-location"><img src="assets/components/images/icon-location.png"
                                alt="icon location" /></span>
                        <span><?php echo isset($footerInfo['place_2']) ? htmlspecialchars($footerInfo['place_2']) : ''; ?></span>
                    </div>
                    <div class="store-info">
                        <div class="open-hour">
                            <span><img src="assets/components/images/icon-watch.png" alt="icon watch" /></span>
                            <span><?php echo isset($footerInfo['working_hour_2']) ? htmlspecialchars($footerInfo['working_hour_2']) : ''; ?></span>
                        </div>
                        <div class="phone-num">
                            <span><img src="assets/components/images/icon-phone.png" alt="icon phone" /></span>
                            <span><?php echo isset($footerInfo['phone_2']) ? htmlspecialchars($footerInfo['phone_2']) : ''; ?></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="contact">
                <span class="footer-contact-us">Contact Us</span>
                <div class="hotline">
                    <span><img src="assets/components/images/icon-phone.png" alt="icon phone" /></span>
                    <span>Hotline: <?php echo isset($footerInfo['hotline']) ? htmlspecialchars($footerInfo['hotline']) : ''; ?></span>
                </div>
                <div class="service">
                    <span><img src="assets/components/images/icon-service.png" alt="img service" /></span>
                    <span>Customer service</span>
                </div>
                <div class="media-links">
                    <ul>
                        <li>
                            <a href="#">
                                <img src="assets/components/images/icon-fb.png" alt="icon facebook" />
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <img src="assets/components/images/icon-ig.png" alt="icon instagram" />
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <img src="assets/components/images/icon-x.png" alt="icon x" />
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <img src="assets/components/images/icon-tt.png" alt="icon tiktok" />
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <img src="assets/components/images/icon-yt.png" alt="icon youtube" />
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="subscribe">
                <div class="subscribe-title">
                    <span class="subscribe-title1">Enter email</span>
                    <span class="subscribe-title2">to receive promotional information</span>
                </div>
                <div class="subscribe-form">
                    <input type="email" class="subscribe-input" placeholder="Enter your email here" />
                    <button type="button" class="btn btn-primary btn-subscribe">
                        <span class="btn-label">Subcribe</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="copyright">
        <span><?php echo isset($footerInfo['copyright']) ? htmlspecialchars($footerInfo['copyright']) : ''; ?></span>
    </div>

    <!-- <img src="assets/components/images/logo-img-1.png" alt=""> -->
</footer>