<?php
// Restore session if expired but cookie exists
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
$notLoginCond = !isset($_SESSION["mySession"]);

// Generate CSRF token if not set
if (!isset($_SESSION["csrf_token"])) {
    $_SESSION["csrf_token"] = bin2hex(random_bytes(32));
}
?>

<?php if ($notLoginCond): ?>
<div>Please login as a member first!</div>
<br>
<a href="/webprogramming_assignment_242/login">Go to Login</a>

<?php else: ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart - Tasty Bites</title>
    <link rel="stylesheet" href="app/views/user/cart/cart.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
</head>
<body>
    <main>
        <section class="cart-section">
            <div class="container">
                <h1>Your Cart</h1>

                <?php if (isset($deleteSuccess) && $deleteSuccess): ?>
                    <p class="success-message">Item removed successfully.</p>
                <?php endif; ?>
                <?php if (isset($deleteError)): ?>
                    <p class="error-message"><?php echo htmlspecialchars($deleteError); ?></p>
                <?php endif; ?>
                <?php if (isset($quantitySuccess) && $quantitySuccess): ?>
                    <p class="success-message">Quantity updated successfully.</p>
                <?php endif; ?>
                <?php if (isset($quantityError)): ?>
                    <p class="error-message"><?php echo htmlspecialchars($quantityError); ?></p>
                <?php endif; ?>
                <?php if (isset($checkoutError)): ?>
                    <p class="error-message"><?php echo htmlspecialchars($checkoutError); ?></p>
                <?php endif; ?>

                <?php if ($checkoutSuccess): ?>
                    <div class="checkout-confirmation">
                        <p>Checkout successful! Your order is now being processed.</p>
                        <a href="/webprogramming_assignment_242/items" class="continue-shopping">Continue Shopping</a>
                    </div>
                <?php elseif ($order && $orderItems && $orderItems->num_rows > 0): ?>
                    <table class="cart-table">
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>Product</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Subtotal</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($item = $orderItems->fetch_assoc()): ?>
                                <tr>
                                    <td class="image-cell">
                                        <img src="app/views/user/items/img/<?php echo htmlspecialchars($item['Image']); ?>" alt="<?php echo htmlspecialchars($item['ProductName']); ?>">
                                    </td>
                                    <td><?php echo htmlspecialchars($item['ProductName']); ?></td>
                                    <td>$<?php echo number_format($item['Price'], 2); ?></td>
                                    <td class="quantity-cell">
                                        <!-- Decrease Quantity -->
                                        <form method="POST" action="" class="quantity-form">
                                            <input type="hidden" name="action" value="update_quantity">
                                            <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($item['ProductID']); ?>">
                                            <input type="hidden" name="change" value="decrease">
                                            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">
                                            <button type="submit" class="quantity-btn">-</button>
                                        </form>
                                        <span class="quantity-value"><?php echo htmlspecialchars($item['Quantity']); ?></span>
                                        <!-- Increase Quantity -->
                                        <form method="POST" action="" class="quantity-form">
                                            <input type="hidden" name="action" value="update_quantity">
                                            <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($item['ProductID']); ?>">
                                            <input type="hidden" name="change" value="increase">
                                            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">
                                            <button type="submit" class="quantity-btn">+</button>
                                        </form>
                                    </td>
                                    <td>$<?php echo number_format($item['Price'] * $item['Quantity'], 2); ?></td>
                                    <td>
                                        <!-- Delete Item -->
                                        <form method="POST" action="">
                                            <input type="hidden" name="action" value="delete">
                                            <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($item['ProductID']); ?>">
                                            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">
                                            <button type="submit" class="remove-btn">Remove</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>

                    <div class="cart-panels">
                        <div class="shipper-info-panel">
                            <h3>Shipper Info</h3>

                            <?php if ($shipper): ?>
                                <div class="shipper-details">
                                    <p><strong>Name:</strong> <?php echo htmlspecialchars($shipper['ShipperName']); ?></p>
                                    <p><strong>License Plate:</strong> <?php echo htmlspecialchars($shipper['CarID']); ?></p>
                                    <p><strong>Phone:</strong> <?php echo htmlspecialchars($shipper['Phone']); ?></p>
                                    <p><strong>Gender:</strong> <?php echo htmlspecialchars($shipper['Gender']); ?></p>
                                </div>
                                <div class="shipper-avatar">
                                    <img src="app/views/user/shippers/img/<?php echo htmlspecialchars($shipper['Avatar']); ?>" alt="<?php echo htmlspecialchars($shipper['ShipperName']); ?>">
                                </div>
                            <?php else: ?>
                                <p>Shipper information not available.</p>
                            <?php endif; ?>
                        </div>
                        <div class="cart-subtotal-panel">
                            <h3>Cart Subtotal</h3>
                            <p><span>Order Subtotal:</span> <span>$<?php echo number_format($order['TotalAmount'], 2); ?></span></p>
                            <p><span>Shipping:</span> <span>Free Shipping</span></p>
                            <p><span>Total:</span> <span>$<?php echo number_format($order['TotalAmount'], 2); ?></span></p>
                        </div>
                    </div>

                    <div class="cart-actions">
                        <a href="/webprogramming_assignment_242/items" class="continue-shopping">Continue Shopping</a>
                        <form method="POST" action="" class="checkout-form">
                            <input type="hidden" name="action" value="checkout">
                            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">
                            <button type="submit" class="checkout-btn">Checkout</button>
                        </form>
                    </div>
                <?php else: ?>
                    <p>Your cart is empty.</p>
                    <a href="/webprogramming_assignment_242/items" class="continue-shopping">Continue Shopping</a>
                <?php endif; ?>
            </div>
        </section>
    </main>
</body>
</html>
<?php endif; ?>
