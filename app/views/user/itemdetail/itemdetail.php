<?php
//session_start();

// Login check snippet
require_once "app/models/UserModel.php";
require_once "app/models/TokenModel.php";
require_once "app/models/ItemsModel.php";

$userModel = new UserModel();
$tokenModel = new TokenModel();
$itemsModel = new ItemsModel();

if (!isset($_SESSION["mySession"]) && isset($_COOKIE["usernameEmail"])) {
    $token = $_COOKIE["usernameEmail"];
    if ($tokenModel->checkTokenExists($token)) {
        $user = $userModel->getUserByToken($token);
        if ($user) {
            $_SESSION["mySession"] = $user["Username"];
        }
    }
}

// Check if user is not logged in (simplified condition)
$notLoginCond = !isset($_SESSION["mySession"]);

// Check if the item is already in the cart (only if logged in and item exists)
$isInCart = false;
if (!$notLoginCond && $item) {
    $userId = $userModel->checkUsernameExists($_SESSION["mySession"]);
    if ($userId) {
        $order = $itemsModel->getPendingOrder($userId);
        if ($order) {
            $orderItems = $itemsModel->getOrderItems($order['OrderID']);
            while ($orderItem = $orderItems->fetch_assoc()) {
                if ($orderItem['ProductID'] == $item['ProductID']) {
                    $isInCart = true;
                    break;
                }
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Item Detail - Tasty Bites</title>
    <link rel="stylesheet" href="app/views/user/items/items.css"> <!-- Reuse items.css for the grid -->
    <link rel="stylesheet" href="app/views/user/itemdetail/itemdetail.css"> <!-- Specific styles for item detail -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <style>
        /* Add style for greyed-out button */
        .order-now-btn:disabled {
            background-color: #cccccc;
            cursor: not-allowed;
        }
    </style>
</head>
<body>
    <main>
        <!-- Item Detail Section -->
        <section class="item-detail-section">
            <div class="container">
                <?php if ($item): ?>
                    <div class="item-detail">
                        <div class="item-image">
                            <img src="app/views/user/items/img/<?php echo htmlspecialchars($item['Image']); ?>" alt="<?php echo htmlspecialchars($item['ProductName']); ?>">
                        </div>
                        <div class="item-info">
                            <h1><?php echo htmlspecialchars($item['ProductName']); ?></h1>
                            <p class="category">Category: <?php echo htmlspecialchars($item['CategoryName']); ?></p>
                            <p class="description"><?php echo htmlspecialchars($item['Description']); ?></p>
                            <p class="price">Price: $<?php echo number_format($item['Price'], 2); ?></p>
                            <div class="button-group">
                                <?php if ($notLoginCond): ?>
                                    <p class="login-message">Please <a href="/webprogramming_assignment_242/login">log in</a> to order or view cart.</p>
                                <?php else: ?>
                                    <?php if (isset($orderError)): ?>
                                        <p class="error-message"><?php echo htmlspecialchars($orderError); ?></p>
                                    <?php endif; ?>
                                    <form method="POST" action="">
                                        <input type="hidden" name="order_item" value="1">
                                        <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($item['ProductID']); ?>">
                                        <button type="submit" class="order-now-btn" <?php echo $isInCart ? 'disabled' : ''; ?>>
                                            <?php echo $isInCart ? 'Item already in cart' : 'Order Now'; ?>
                                        </button>
                                    </form>
                                    <a href="/webprogramming_assignment_242/cart" class="go-to-cart-link">View in cart</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <p>Item not found.</p>
                <?php endif; ?>
            </div>
        </section>

        <!-- See More Items Link Above Grid -->
        <section class="see-more-section">
            <div class="container">
                <a href="/webprogramming_assignment_242/items" class="see-more-link">See more items</a>
            </div>
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
                        // Add promo banners at specific positions (after 6th item)
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

    <!-- Popup for Order Confirmation -->
    <div class="popup" id="orderPopup">
        <div class="popup-content">
            <span class="close-btn" onclick="closePopup()">×</span>
            <p>Item added to cart</p>
        </div>
    </div>

    <script>
        function showPopup() {
            document.getElementById('orderPopup').style.display = 'flex';
        }

        function closePopup() {
            document.getElementById('orderPopup').style.display = 'none';
        }

        // Close popup when clicking outside of it
        window.onclick = function(event) {
            const popup = document.getElementById('orderPopup');
            if (event.target === popup) {
                popup.style.display = 'none';
            }
        }

        // Show popup if order was successful
        <?php if (isset($orderSuccess) && $orderSuccess): ?>
            showPopup();
        <?php endif; ?>
    </script>
</body>
</html>