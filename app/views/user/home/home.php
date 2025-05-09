<?php

if (isset($_SESSION["success_message"])) {
    echo '<script>alert("' . $_SESSION['success_message'] . '");</script>';
    unset($_SESSION['success_message']);
}
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
    <title>Homepage</title>
    <link rel="stylesheet" href="<?php echo asset('app/views/user/home/home.css'); ?>">
    <link rel="stylesheet" href="<?php echo asset('assets/components/style.css'); ?>">

</head>

<body>
    <div class="container">
        <section class="section-banner">
            <div class="banner-content">
                <a class="banner" href="items.php">
                    <img src="<?php echo asset('app/views/user/home/img/banner.png'); ?>" alt="Banner Image"
                        class="img-banner">
                </a>
            </div>
        </section>
        <section class="section-popular-dishes">
            <span class="sub-title">Food Items</span>
            <h2 class="title">Popular Dishes</h2>
            <div class="popular-dishes">
                <div class="img-popular">
                    <a href="items.php">
                        <img src="<?php echo asset('app/views/user/home/img/image_Dishes_1.png'); ?>"
                            alt="Popular Dish 1" class="img-popular-1">
                    </a>
                </div>
                <div class="img-popular">
                    <a href="items.php">
                        <img src="<?php echo asset('app/views/user/home/img/image_Dishes_2.png'); ?>"
                            alt="Popular Dish 2" class="img-popular-2">
                    </a>
                </div>
                <div class="img-popular">
                    <a href="items.php">
                        <img src="<?php echo asset('app/views/user/home/img/image_Dishes_3.png'); ?>"
                            alt="Popular Dish 3" class="img-popular-3">
                    </a>
                </div>
                <div class="img-popular">
                    <a href="items.php">
                        <img src="<?php echo asset('app/views/user/home/img/image_Dishes_4.png'); ?>"
                            alt="Popular Dish 4" class="img-popular-4">
                    </a>
                </div>
                <div class="img-popular">
                    <a href="items.php">
                        <img src="<?php echo asset('app/views/user/home/img/image_Dishes_5.png'); ?>"
                            alt="Popular Dish 5" class="img-popular-5">
                    </a>
                </div>
            </div>
        </section>
        <section class="section-special section-hidden">
            <h2 class="title">SPECIALS MENU FOR ALL TIME</h2>
            <div class="special-menu">
                <div class="box">
                    <a href="items.php" class="special-menu-item">
                        <img src="<?php echo asset('app/views/user/home/img/image_specialManu_1.png'); ?>"
                            alt="Special Dish 1" class="img-special">
                        <span class="dishes-name">Burger</span>
                    </a>
                </div>
                <div class="box">
                    <a href="items.php" class="special-menu-item">
                        <img src="<?php echo asset('app/views/user/home/img/image_specialManu_2.png'); ?>"
                            alt="Special Dish 2" class="img-special">
                        <span class="dishes-name">Fried chicken</span>
                    </a>
                </div>
                <div class="box">
                    <a href="items.php" class="special-menu-item">
                        <img src="<?php echo asset('app/views/user/home/img/image_specialManu_3.png'); ?>"
                            alt="Special Dish 3" class="img-special">
                        <span class="dishes-name">Doner with Grilled Chicken</span>
                    </a>
                </div>
                <div class="box">
                    <a href="items.php" class="special-menu-item">
                        <img src="<?php echo asset('app/views/user/home/img/image_specialManu_4.png'); ?>"
                            alt="Special Dish 4" class="img-special">
                        <span class="dishes-name">Pizza</span>
                    </a>
                </div>
                <div class="box">
                    <a href="items.php" class="special-menu-item">
                        <img src="<?php echo asset('app/views/user/home/img/image_specialManu_5.png'); ?>"
                            alt="Special Dish 5" class="img-special">
                        <span class="dishes-name">Hot Dogs</span>
                    </a>
                </div>
                <div class="box">
                    <a href="items.php" class="special-menu-item">
                        <img src="<?php echo asset('app/views/user/home/img/image_specialManu_6.png'); ?>"
                            alt="Special Dish 6" class="img-special">
                        <span class="dishes-name">Chicken Skewers</span>
                    </a>
                </div>
                <div class="box">
                    <a href="items.php" class="special-menu-item">
                        <img src="<?php echo asset('app/views/user/home/img/image_specialManu_7.png'); ?>"
                            alt="Special Dish 7" class="img-special">
                        <span class="dishes-name">Greek Salad</span>
                    </a>
                </div>
                <div class="box">
                    <a href="items.php" class="special-menu-item">
                        <img src="<?php echo asset('app/views/user/home/img/image_specialManu_8.png'); ?>"
                            alt="Special Dish 8" class="img-special">
                        <span class="dishes-name">Dahi Puri</span>
                    </a>
                </div>
                <div class="box">
                    <a href="items.php" class="special-menu-item">
                        <img src="<?php echo asset('app/views/user/home/img/image_specialManu_9.png'); ?>"
                            alt="Special Dish 9" class="img-special">
                        <span class="dishes-name">Ice cream with Chocolate</span>
                    </a>
                </div>
                <div class="box">
                    <a href="items.php" class="special-menu-item">
                        <img src="<?php echo asset('app/views/user/home/img/image_specialManu_10.png'); ?>"
                            alt="Special Dish 10" class="img-special">
                        <span class="dishes-name">Cocktail Glasses</span>
                    </a>
                </div>
            </div>
        </section>
        <section class="section-our section-hidden">
            <span class="sub-title text-red">OUR RESTAURANT</span>
            <div class="our-restaurant-content">

                <img src="<?php echo asset('app/views/user/home/img/img-our.png'); ?>" alt="our restaurant images"
                    class="img-our">

                <div class="our-content">
                    <h2 class="title text-darkblue">For every specialoccasion there’s heritaste</h2>
                    <p class="normal-text">Tastybite is a cozy restaurant offering a variety of delicious dishes,
                        blending traditional and international flavors. Perfect for family meals or casual gatherings!
                    </p>
                    <div class="restaurant-story">
                        <div class="success">
                            <img src="<?php echo asset('app/views/user/home/img/Group-growth.png'); ?>"
                                alt="success icon" class="icon-success">
                            <div class="success-content">
                                <span class="title">Success Story</span>
                                <p class="normal-text">Certain circumstances and owing to the claims of duty obligations
                                    of business it will frequently.</p>
                            </div>
                        </div>
                        <div class="success">
                            <img src="<?php echo asset('app/views/user/home/img/Group-cook.png'); ?>" alt="cook icon"
                                class="icon-cook">
                            <div class="success-content">
                                <span class="title">Passionate Chefs</span>
                                <p class="normal-text">Duty or the obligations of business it frequently occur pleasures
                                    have to be repudiated.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="section-reason section-hidden">
            <span class="sub-title">Why We are the best</span>
            <div class="reason">
                <div class="reason-box">
                    <img src="<?php echo asset('app/views/user/home/img/reason1.png'); ?>" alt="reason icon"
                        class="icon-reason">
                    <h3 class="sub-title">Passionate Chefs</h3>
                    <p class="normal-text">Beguiled and demoralized by all get charms pleasure the moments ever so
                        blinded by desire.</p>
                </div>
                <div class="reason-box">
                    <img src="<?php echo asset('app/views/user/home/img/reason2.png'); ?>" alt="reason2 icon"
                        class="icon-reason">
                    <h3 class="sub-title">100 % Fresh Foods</h3>
                    <p class="normal-text">Beguiled and demoralized by all get charms pleasure the moments ever so
                        blinded by desire.
                    </p>
                </div>
                <div class="reason-box">
                    <img src="<?php echo asset('app/views/user/home/img/reason3.png'); ?>" alt="reason3 icon"
                        class="icon-reason">
                    <h3 class="sub-title">Memorable Ambience</h3>
                    <p class="normal-text">Beguiled and demoralized by all get charms pleasure the moments ever so
                        blinded by desire.
                    </p>
                </div>
            </div>
        </section>
        <section class="section-location section-hidden">
            <h2 class="title">VISIT US</h2>
            <div class="address-content">
                <div class="address">
                    <div class="contact-details">
                        <div class="address-detail">
                            <span class="title text-darkblue">ADDRESS</span>
                            <div class="branch1">
                                <img src="<?php echo asset('app/views/user/home/img/location.png'); ?>"
                                    alt="location icon" class="icon-location">
                                <div class="branch1-address">
                                    <span class="normal-text">88, 01 Song Hanh Street, An Phu Ward, District 2,
                                        HCMC</span>
                                    <span class="normal-text">+387 847 976</span>
                                    <span class="normal-text">tastybite@restaurant.com</span>
                                </div>
                            </div>
                        </div>
                        <div class="working-hour">
                            <span class="title text-darkblue">WORKING HOURS</span>
                            <span class="normal-text">7:30 am to 9:30pm on Weekdays</span>
                        </div>
                        <div class="shipping">
                            <div class="delivery-info">
                                <span class="sub-title">Delivery Order</span>
                                <span class="normal-text">+387 847 976</span>
                            </div>
                            <img src="<?php echo asset('app/views/user/home/img/icon-shipper.png'); ?>"
                                alt="shipper icon" class="icon-shipper">
                            <a href="items.php" type="button" class="btn btn-primary btn-mini">Order Now</a>
                        </div>

                    </div>
                </div>
                <div class="map">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3919.1213652801835!2d106.74597867530937!3d10.802015658720652!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x317527921e9a0c0d%3A0x4d8b9ff3fc2e99c2!2sMeat%20%26%20Meet%20BBQ%20Estella!5e0!3m2!1svi!2s!4v1745623812428!5m2!1svi!2s"
                        width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>

        </section>


    </div>
    <section class="section-review section-hidden">
        <div class="container">
            <div class="review-content">
                <h2 class="title text-white">Đánh giá từ khách hàng</h2>
                <div class="review-box">
                    <?php
                    require_once "app/database/database.php";
                    $db = new Database();
                    $conn = $db->connect();
                    $query = "SELECT * FROM (
                            SELECT r.*, u.Username, u.Avatar, p.ProductName,
                                   ROW_NUMBER() OVER (PARTITION BY r.UserID ORDER BY r.CreatedAt DESC) as rn
                            FROM reviews r
                            JOIN users u ON r.UserID = u.UserID
                            JOIN products p ON r.ProductID = p.ProductID
                          ) AS ranked_reviews
                          WHERE rn = 1
                          ORDER BY CreatedAt DESC
                          LIMIT 3";

                    $result = $conn->query($query);

                    if ($result && $result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            // lấy Avatar
                            $defaultAvatar = asset('app/views/user/home/img/default_avatar.png');
                            $avatar = !empty($row['Avatar']) ? $row['Avatar'] : $defaultAvatar;

                            $ratingStars = str_repeat('★', $row['Rating']) . str_repeat('☆', 5 - $row['Rating']);
                    ?>
                    <div class="review-item">
                        <div class="avatar">
                            <img src="<?php echo $avatar; ?>"
                                alt="Avatar của <?php echo htmlspecialchars($row['Username']); ?>" class="user-avatar"
                                onerror="this.src='<?php echo $defaultAvatar; ?>'">
                        </div>
                        <div class="review-header">
                            <div class="sub-title"><?php echo htmlspecialchars($row['Username']); ?></div>
                            <div class="rating"><?php echo $ratingStars; ?></div>
                        </div>
                        <p class="normal-text"><?php echo htmlspecialchars($row['Comment']); ?></p>
                        <small class="product-name">Đã thử: <?php echo htmlspecialchars($row['ProductName']); ?></small>
                        <small class="review-date"><?php echo date('d/m/Y', strtotime($row['CreatedAt'])); ?></small>
                    </div>
                    <?php
                        }
                    } else {
                        // không có review
                        for ($i = 1; $i <= 3; $i++) {
                        ?>
                    <div class="review-item">
                        <div class="avatar-container">
                            <img src="<?php echo asset('app/views/user/home/img/default_avatar.png'); ?>"
                                alt="Khách hàng mẫu" class="user-avatar">
                        </div>
                        <div class="sub-title">Khách hàng mẫu</div>
                        <p class="normal-text">Chưa có đánh giá nào. Hãy là người đầu tiên đánh giá!</p>
                    </div>
                    <?php
                        }
                    }

                    $conn->close();
                    ?>
                </div>
            </div>
        </div>
    </section>
    <script>
    const observer = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('section-visible');
                observer.unobserve(entry.target);
            }
        });
    }, {
        threshold: 0.5
    });

    const sections = document.querySelectorAll('.section-hidden');
    sections.forEach(section => {
        observer.observe(section);
    });
    </script>
</body>

</html>