<?php
require_once __DIR__ . '/../../../config/config.php';
require_once __DIR__ . '/../../../database/database.php';

$db = new Database();
$conn = $db->connect();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php
    function asset($path)
    {
        return '/webprogramming_assignment_242/' . ltrim($path, '/');
    }
    ?>
    <title>Contact</title>
    <link rel="stylesheet" href="<?php echo asset('app/views/user/home/home.css'); ?>">
    <link rel="stylesheet" href="<?php echo asset('app/views/user/contact/contact.css'); ?>">
    <link rel="stylesheet" href="<?php echo asset('assets/components/style.css'); ?>">
</head>
<body>
    <div class="container">
        <h2 class="contact-us">Contact Us</h2>
        <section class="section-company-info">
            <div class="company-info-container">
                <div class="company-info">
                    <div class="address-details">
                        <h3 class="title text-red">ADDRESS</h3>
                            <div class="branch1">
                                <img src="<?php echo asset('app/views/user/home/img/location.png'); ?>" alt="location icon" class="icon-location">
                            <div class="branch1-address">
                                <span class="normal-text">88, 01 Song Hanh Street, An Phu Ward, District 2, HCMC</span>
                                <span class="normal-text">+387 847 976</span>
                                <span class="normal-text">tastybite@restaurant.com</span>
                            </div>
                        </div>
                    </div>
                    <div class="working-hour">
                        <span class="title text-red">WORKING HOURS</span>
                            <span class="normal-text">7:30 am to 9:30pm on Weekdays</span>
                    </div>
                    <div class="media">
                        <h3 class="title text-red">FOLLOW US</h3>
                        <div class="social-media">
                            <a href="#" target="_blank"><img src="<?php echo asset('app/views/user/contact/img/facebook.png'); ?>" alt="facebook icon" class="icon-facebook"></a>
                            <a href="#" target="_blank"><img src="<?php echo asset('app/views/user/contact/img/instagram.png'); ?>" alt="instagram icon" class="icon-instagram"></a>
                            <a href="#" target="_blank"><img src="<?php echo asset('app/views/user/contact/img/x.png'); ?>" alt="x icon" class="icon-x"></a>
                        </div>
                            
                    </div>
                </div>
                <div class="map">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3919.1213652801835!2d106.74597867530937!3d10.802015658720652!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x317527921e9a0c0d%3A0x4d8b9ff3fc2e99c2!2sMeat%20%26%20Meet%20BBQ%20Estella!5e0!3m2!1svi!2s!4v1745623812428!5m2!1svi!2s"
                        width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>
        </section>
        <section class="section-question">
            <img src="<?php echo asset('app/views/user/contact/img/question.png'); ?>" alt="potato-chip ask" class="question-img">
        </section>
        <section class="section-form">
            <div class="contact-form">
                <form action="contact/process.php" method="POST">
                    <div class="form-group">
                        <label class="sub-title" for="name">Họ và tên</label>
                        <input type="text" id="name" name="name" required>
                    </div>
                    
                    <div class="form-group">
                        <label class="sub-title" for="phone">Số điện thoại</label>
                        <input type="tel" id="phone" name="phone" required>
                    </div>
                    
                    <div class="form-group">
                        <label class="sub-title" for="email">Email</label>
                        <input type="email" id="email" name="email" required>
                    </div>
                    
                    <div class="form-group">
                        <label class="sub-title" for="subject">Tiêu đề</label>
                        <input type="text" id="subject" name="subject">
                    </div>
                    
                    <div class="form-group">
                        <label class="sub-title" for="message">Nội dung</label>
                        <textarea id="message" name="message" required></textarea>
                    </div>
                    
                    <button type="submit" class="btn btn-primary btn-mini btn-submit">Gửi liên hệ</button>
                </form>
            </div>
        </section>
    </div>