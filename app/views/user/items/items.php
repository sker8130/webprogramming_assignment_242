<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Our Menu - Tasty Bites</title>
    <link rel="stylesheet" href="app/views/user/items/items.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
</head>
<body>

    <main>
        <!-- Search Area -->
        <section class="search-section">
            <div class="search-prompt">
                <img src="app/views/user/items/img/potatochip.png" alt="Fries icon">
                <h2>What do you wanna eat today?</h2>
            </div>
            <form action="/webprogramming_assignment_242/items" method="GET" class="search-form">
                <input type="text" name="keyword" placeholder="Search your Items" value="<?php echo htmlspecialchars($keyword ?? ''); ?>">
                <button type="submit"><i class="fas fa-search"></i></button>
            </form>
        </section>

        <!-- Product Listing Area -->
        <section class="product-grid">
            <div class="container">
                <?php
                if ($items && $items->num_rows > 0) {
                    $count = 0;
                    while ($product = $items->fetch_assoc()) {
                        // Display product cards
                        ?>
                        <div class="product-card">
                            <a href="/webprogramming_assignment_242/itemdetail?id=<?php echo htmlspecialchars($product['ProductID']); ?>">
                                <img src="app/views/user/items/img/<?php echo htmlspecialchars($product['Image']); ?>" alt="<?php echo htmlspecialchars($product['ProductName']); ?>">
                                <div class="product-info">
                                    <h3><?php echo htmlspecialchars($product['ProductName']); ?></h3>
                                    <p><?php echo htmlspecialchars($product['Description']); ?></p>
                                    <span class="price">From $<?php echo number_format($product['Price'], 2); ?></span>
                                </div>
                            </a>
                        </div>
                        <?php
                        $count++;
                        // Add promo banners at specific positions (after 4th and 8th items)
                        if ($count == 6) {
                            ?>
                            <div class="promo-banner">
                                <img src="app/views/user/items/img/promo_banner_1.jpg" alt="Promo Banner 1">
                            </div>
                            <?php
                        } 
                        if ($count >= 12) {
                            break;
                        }
                    }
                } else {
                    // Display message if no products found
                    echo "<p>No item found.</p>";
                }
                ?>
            </div>
        </section>
    </main>

</body>
</html>