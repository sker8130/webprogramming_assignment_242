<?php
session_start();

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
// Redirect non-admin users
if (!isset($_SESSION["mySession"]) || (isset($_SESSION["mySession"]) && ($_SESSION["mySession"] != "admin" && $_SESSION["mySession"] != "admin@gmail.com"))) {
    header("Location: /webprogramming_assignment_242/");
}

// Display success/error messages
if (isset($_SESSION["success_message"])) {
    echo '<script>alert("' . $_SESSION['success_message'] . '");</script>';
    unset($_SESSION['success_message']);
}
if (isset($_SESSION["error_message"])) {
    echo '<script>alert("' . $_SESSION['error_message'] . '");</script>';
    unset($_SESSION['error_message']);
}

// Group orders by UserID
$ordersByUser = [];
while ($order = $orders->fetch_assoc()) {
    $userId = $order['UserID'];
    if (!isset($ordersByUser[$userId])) {
        $ordersByUser[$userId] = [
            'Username' => $order['Username'],
            'Orders' => []
        ];
    }
    $ordersByUser[$userId]['Orders'][] = $order;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Manage Orders</title>

    <base href="/webprogramming_assignment_242/">

    <link rel="shortcut icon" href="assets/compiled/svg/favicon.svg" type="image/x-icon" />
    <link rel="shortcut icon"
        href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACEAAAAiCAYAAADRcLDBAAAEs2lUWHRYTUw6Y29tLmFkb2JlLnhtcAAAAAAAPD94cGFja2V0IGJlZ2luPSLvu78iIGlkPSJXNU0wTXBDZWhpSHpyZVN6TlRjemtjOWQiPz4KPHg6eG1wbWV0YSB4bWxuczp4PSJhZG9iZTpuczptZXRhLyIgeDp4bXB0az0iWE1QIENvcmUgNS41LjAiPgogPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4KICA8cmRmOkRlc2NyaXB0aW9uIHJkZjphYm91dD0iIgogICAgeG1sbnM6ZXhpZj0iaHR0cDovL25zLmFkb2JlLmNvbS9leGlmLzEuMC8iCiAgICB4bWxuczp0aWZmPSJodHRwOi8vbnMuYWRvYmUuY29tL3RpZmYvMS4wLyIKICAgIHhtbG5zOnBob3Rvc2hvcD0iaHR0cDovL25zLmFkb2JlLmCvbS9waG90b3Nob3AvMS4wLyIKICAgIHhtbG5zOnhtcD0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wLyIKICAgIHhtbG5zOnhtcE1NPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvbW0vIgogICAgeG1sbnM6c3RFdnQ9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZUV2ZW50IyIKICAgZXhpZjpQaXhlbFhEaW1lbnNpb249IjMzIgogICBleGlmOlBpeGVsWURpbWVuc2lvbj0iMzQiCiAgIGV4aWY6Q29sb3JTcGFjZT0iMSIKICAgdGlmZjpJbWFnZVdpZHRoPSIzMyIKICAgdGlmZjpJbWFnZUxlbmd0aD0iMzQiCiAgIHRpZmY6UmVzb2x1dGlvblVuaXQ9IjIiCiAgIHRpZmY6WFJlc29sdXRpb249Ijk2LjAiCiAgIHRiZmY6WVJlc29sdXRpb249Ijk2LjAiCiAgIHBob3Rvc2hvcDpDb2xvck1vZGU9IjMiCiAgIHBob3Rvc2hvcDpJQ0NQcm9maWxlPSJzUkdCIElFQzYxOTY2LTIuMSIKICAgeG1wOk1vZGlmeURhdGU9IjIwMjItMDMtMzFUMTA6NTA6MjMrMDI6MDAiCiAgIHhtcDpNZXRhZGF0YURhdGU9IjIwMjItMDMtMzFUMTA6NTA6MjMrMDI6MDAiPgogICA8eG1wTU06SGlzdG9yeT4KICAgIDxyZGY6U2VxPgogICAgIDxyZGY6bGkKICAgICAgc3RFdnQ6YWN0aW9uPSJwcm9kdWNlZCIKICAgICAgc3RFdnQ6c29mdHdhcmVBZ2VudD0iQWZmaW5pdHkgRGVzaWduZXIgMS4xMC4xIgogICAgICBzdEV2dDp3aGVuPSIyMDIyLTAzLTMxVDEwOjUwOjIzKzAyOjAwIi8+CiAgICA8L3JkZjpTZXE+CiAgIDwveG1wTU06SGlzdG9yeT4KICA8L3JkZjpEZXNjcmlwdGlvbj4KIDwvcmRmOlJERj4KPC94OnhtcG1ldGE+Cjw/eHBhY2tldCBlbmQ9InIiPz5V57uAAAABgmlDQ1BzUkdCIElFQzYxOTY2LTIuMQAAKJF1kc8rRFEUxz9maORHo1hYKC9hISNGTWwsRn4VFmOUX5uZZ36oeTOv954kW2WrKLHxa8FfwFZZK0WkZClrYoOe87ypmWTO7dzzud97z+nec8ETzaiaWd4NWtYyIiNhZWZ2TvE946WZSjqoj6mmPjE1HKWkfdxR5sSbgFOr9Ll/rXoxYapQVik8oOqGJTwqPL5i6Q5vCzeo6dii8KlwpyEXFL519LjLLw6nXP5y2IhGBsFTJ6ykijhexGra0ITl5bRqmWU1fx/nJTWJ7PSUxBbxJkwijBBGYYwhBgnRQ7/MIQIE6ZIVJfK7f/MnyUmuKrPOKgZLpEhj0SnqslRPSEyKnpCRYdXp/9++msneoFu9JgwVT7b91ga+LfjetO3PQ9v+PgLvI1xkC/m5A+h7F32zoLXug38dzi4LWnwHzjeg8UGPGbFfySvuSSbh9QRqZ6H+Gqrm3Z7l9zm+h+iafNUV7O5Bu5z3L/wAdthn7QIme0YAAAAJcEhZcwAADsQAAA7EAZUrDhsAAAJTSURBVFiF7Zi9axRBGIefEw2IdxFBRQsLWUTBaywSK4ubdSGVIY1Y6HZql8ZKCGIqwX/AYLmCgVQKfiDn7jZeEQMWfsSAHAiKqPiB5mIgELWYOW5vzc3O7niHhT/YZvY37/swM/vOzJbIqVq9uQ04CYwCI8AhYAlYAB4Dc7HnrOSJWcoJcBS4ARzQ2F4BZ2LPmTeNuykHwEWgkQGAet9QfiMZjUSt3hwD7psGTWgs9pwH1hC1enMYeA7sKwDxBqjGnvNdZzKZjqmCAKh+U1kmEwi3IEBbIsugnY5avTkEtIAtFhBrQCX2nLVehqyRqFoCAAwBh3WGLAhbgCRIYYinwLolwLqKUwwi9pxV4KUlxKKKUwxC6ZElRCPLYAJxGfhSEOCz6m8HEXvOB2CyIMSk6m8HoXQTmMkJcA2YNTHm3congOvATo3tE3A29pxbpnFzQSiQPcB55IFmFNgFfEQeahaAGZMpsIJIAZWAHcDX2HN+2cT6r39GxmvC9aPNwH5gO1BOPFuBVWAZue0vA9+A12EgjPadnhCuH1WAE8ivYAQ4ohKaagV4gvxi5oG7YSA2vApsCOH60WngKrA3R9IsvQUuhIGY00K4flQG7gHH/mLytB4C42EgfrQb0mV7us8AAMeBS8mGNMR4nwHamtBB7B4QRNdaS0M8GxDEog7iyoAguvJ0QYSBuAOcAt71Kfl7wA8DcTvZ2KtOlJEr+ByyQtqqhTyHTIeB+ONeqi3brh+VgIN0fohUgWGggizZFTplu12yW8iy/YLOGWMpDMTPXnl+Az9vj2HERYqPAAAAAElFTkSuQmCC"
        type="image/png" />

    <link rel="stylesheet" href="assets/extensions/simple-datatables/style.css" />
    <link rel="stylesheet" href="assets/compiled/css/table-datatable.css" />
    <link rel="stylesheet" href="assets/compiled/css/app.css" />
    <link rel="stylesheet" href="assets/compiled/css/app-dark.css" />

    <style>
        /* Custom highlight for Pending orders */
        .pending-highlight {
            background-color: #2b3a5c !important; /* Slightly brighter than Mazer dark theme background */
        }
    </style>
</head>

<body>
    <script src="assets/static/js/initTheme.js"></script>
    <div id="app">

        <?php
        require_once "assets/components/admin/sidebar.php";
        ?>

        <div id="main">

            <?php
            require_once "assets/components/admin/header.php";
            ?>

            <div class="page-heading">
                <div class="page-title">
                    <div class="row">
                        <div class="col-12 col-md-6 order-md-1 order-last">
                            <h3>Manage Orders</h3>
                        </div>
                    </div>
                </div>
                <section class="section">
                    <div class="card">
                        <div class="card-body">
                            <?php foreach ($ordersByUser as $userId => $userData): ?>
                                <h5 class="mt-3">
                                    <button class="btn btn-link" type="button" data-bs-toggle="collapse" data-bs-target="#userOrders<?php echo $userId; ?>" aria-expanded="false" aria-controls="userOrders<?php echo $userId; ?>">
                                        <?php echo htmlspecialchars($userData['Username']); ?> (<?php echo count($userData['Orders']); ?> Orders)
                                    </button>
                                </h5>
                                <div class="collapse show" id="userOrders<?php echo $userId; ?>">
                                    <table class="table table-striped" id="table<?php echo $userId; ?>">
                                        <thead>
                                            <tr>
                                                <th>Order ID</th>
                                                <th>Total Amount</th>
                                                <th>Status</th>
                                                <th>Shipper</th>
                                                <th>Created At</th>
                                                <th>Details</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($userData['Orders'] as $order): ?>
                                                <tr class="<?php echo $order['OrderStatus'] === 'Pending' ? 'pending-highlight' : ''; ?>">
                                                    <td><?php echo htmlspecialchars($order['OrderID']); ?></td>
                                                    <td>$<?php echo number_format($order['TotalAmount'], 2); ?></td>
                                                    <td>
                                                        <form method="post" action="/webprogramming_assignment_242/admin/order/updateStatus">
                                                            <input type="hidden" name="orderId" value="<?php echo htmlspecialchars($order['OrderID']); ?>">
                                                            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">
                                                            <select name="status" class="form-select" onchange="this.form.submit()">
                                                                <option value="Pending" <?php echo $order['OrderStatus'] === 'Pending' ? 'selected' : ''; ?>>Pending<?php echo $order['OrderStatus'] === 'Pending' ? ' (Current Cart)' : ''; ?></option>
                                                                <option value="Processing" <?php echo $order['OrderStatus'] === 'Processing' ? 'selected' : ''; ?>>Processing</option>
                                                                <option value="Completed" <?php echo $order['OrderStatus'] === 'Completed' ? 'selected' : ''; ?>>Completed</option>
                                                                <option value="Cancelled" <?php echo $order['OrderStatus'] === 'Cancelled' ? 'selected' : ''; ?>>Cancelled</option>
                                                            </select>
                                                        </form>
                                                    </td>
                                                    <td>
                                                        <form method="post" action="/webprogramming_assignment_242/admin/orders/updateShipper">
                                                            <input type="hidden" name="orderId" value="<?php echo htmlspecialchars($order['OrderID']); ?>">
                                                            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">
                                                            <select name="shipperId" class="form-select" onchange="this.form.submit()">
                                                                <?php
                                                                $shippers->data_seek(0); // Reset shipper result pointer
                                                                while ($shipper = $shippers->fetch_assoc()): ?>
                                                                    <option value="<?php echo htmlspecialchars($shipper['ShipperID']); ?>" <?php echo $order['ShipperID'] == $shipper['ShipperID'] ? 'selected' : ''; ?>>
                                                                        <?php echo htmlspecialchars($shipper['ShipperName']); ?>
                                                                    </option>
                                                                <?php endwhile; ?>
                                                            </select>
                                                        </form>
                                                    </td>
                                                    <td><?php echo htmlspecialchars($order['CreateAt']); ?></td>
                                                    <td>
                                                        <button class="btn btn-sm btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#orderItems<?php echo $order['OrderID']; ?>" aria-expanded="false" aria-controls="orderItems<?php echo $order['OrderID']; ?>">
                                                            View Items
                                                        </button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="6" class="p-0">
                                                        <div class="collapse" id="orderItems<?php echo $order['OrderID']; ?>">
                                                            <div class="card card-body">
                                                                <?php
                                                                $orderItems = $itemsModel->getOrderItems($order['OrderID']);
                                                                if ($orderItems->num_rows > 0):
                                                                ?>
                                                                    <table class="table table-bordered">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>Product</th>
                                                                                <th>Quantity</th>
                                                                                <th>Price</th>
                                                                                <th>Image</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <?php while ($item = $orderItems->fetch_assoc()): ?>
                                                                                <tr>
                                                                                    <td><?php echo htmlspecialchars($item['ProductName']); ?></td>
                                                                                    <td><?php echo htmlspecialchars($item['Quantity']); ?></td>
                                                                                    <td>$<?php echo number_format($item['Price'], 2); ?></td>
                                                                                    <td>
                                                                                        <img src="app/views/user/items/img/<?php echo htmlspecialchars($item['Image']); ?>" alt="<?php echo htmlspecialchars($item['ProductName']); ?>" style="max-width: 50px;">
                                                                                    </td>
                                                                                </tr>
                                                                            <?php endwhile; ?>
                                                                        </tbody>
                                                                    </table>
                                                                <?php else: ?>
                                                                    <p>No items in this order.</p>
                                                                <?php endif; ?>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                    <script>
                                        // Initialize DataTable for each customer table
                                        new simpleDatatables.DataTable("#table<?php echo $userId; ?>");
                                    </script>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </section>
            </div>

            <footer>
                <div class="footer clearfix mb-0 text-muted">
                    <div class="float-start">
                        <p>2023 © Mazer</p>
                    </div>
                    <div class="float-end">
                        <p>
                            Crafted with
                            <span class="text-danger"><i class="bi bi-heart-fill icon-mid"></i></span>
                            by <a href="https://saugi.me">Saugi</a>
                        </p>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <script src="assets/static/js/components/dark.js"></script>
    <script src="assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="assets/compiled/js/app.js"></script>
    <script src="assets/extensions/simple-datatables/umd/simple-datatables.js"></script>
    <script src="assets/static/js/pages/simple-datatables.js"></script>
</body>

</html>