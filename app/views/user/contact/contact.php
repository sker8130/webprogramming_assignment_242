<?php
require_once __DIR__ . '/../../../config/config.php';
require_once __DIR__ . '/../../../database/database.php';
require_once "app/models/VisitUsModel.php";
$visitUsModel = new VisitUsModel();
$visitUsData = $visitUsModel->getVisitUsData();

// For testing database connection
// $db = new Database();
// $conn = $db->connect();

// Function to get base URL for assets






if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $db = new Database();
    $conn = $db->connect();


    $name = htmlspecialchars(trim($_POST['name']));
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $phone = htmlspecialchars(trim($_POST['phone']));
    $subject = isset($_POST['subject']) ? htmlspecialchars(trim($_POST['subject'])) : '';
    $message = htmlspecialchars(trim($_POST['message']));
    $userid = isset($_POST['userid']) ? htmlspecialchars(trim($_POST['userid'])) : '';


    $errors = [];

    if (empty($name)) {
        $errors[] = "Vui lòng nhập họ và tên";
    }

    if (empty($email)) {
        $errors[] = "Vui lòng nhập email";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Email không hợp lệ";
    }

    if (empty($phone)) {
        $errors[] = "Vui lòng nhập số điện thoại";
    }

    if (empty($message)) {
        $errors[] = "Vui lòng nhập nội dung liên hệ";
    }


    if (!empty($errors)) {
        $error_string = implode("<br>", $errors);
        header("Location: /webprogramming_assignment_242/contact?error=" . urlencode($error_string));
        exit();
    }


    try {
        $stmt = $conn->prepare("INSERT INTO contacts (Name, Email, Message,UserID, Status) VALUES (?, ?, ?,?, 'pending')");
        $stmt->bind_param("ssss", $name, $email, $message, $userid);

        if ($stmt->execute()) {
            header("Location: /webprogramming_assignment_242/contact?success=1");
            exit();
        } else {
            throw new Exception($conn->error);
        }
    } catch (Exception $e) {
        header("Location: /webprogramming_assignment_242/contact?error=" . urlencode("Có lỗi xảy ra khi gửi liên hệ: " . $e->getMessage()));
        exit();
    }
};

function asset($path)
{
    return '/webprogramming_assignment_242/' . ltrim($path, '/');
};


$success = isset($_GET['success']) ? $_GET['success'] : '';
$error = isset($_GET['error']) ? $_GET['error'] : '';



if (isset($_GET['mark_read'])) {
    $db = new Database();
    $conn = $db->connect();
    $contactID = intval(value: $_GET['mark_read']);
    $userid = isset($_SESSION['userid']) ? $_SESSION['userid'] : null;
    $stmt = $conn->prepare("UPDATE contacts SET is_user_read = 1 WHERE ContactID = ? AND UserID = ?");
    $stmt->bind_param("ii", $contactID, $userid);
    $stmt->execute();
}
$db = new Database();
$conn = $db->connect();

$userid = isset($_SESSION['userid']) ? $_SESSION['userid'] : null;

$stmt = $conn->prepare("SELECT * FROM contacts WHERE UserID = ? AND Reply IS NOT NULL AND is_user_read = 0");
$stmt->bind_param("i", $userid);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact</title>
    <link rel="stylesheet" href="<?php echo asset('app/views/user/home/home.css'); ?>">
    <link rel="stylesheet" href="<?php echo asset('app/views/user/contact/contact.css'); ?>">
    <link rel="stylesheet" href="<?php echo asset('assets/components/style.css'); ?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />

    <style>
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 4px;
            width: 100%;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2 class="contact-us">Contact Us</h2>

        <?php if ($success): ?>
            <div class="alert alert-success">
                Cảm ơn bạn đã gửi liên hệ! Chúng tôi sẽ phản hồi trong thời gian sớm nhất.
            </div>
        <?php endif; ?>

        <?php if ($error): ?>
            <div class="alert alert-danger">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>

        <section class="section-company-info">
            <div class="company-info-container">
                <div class="company-info">
                    <div class="address-details">
                        <h3 class="title text-red">ADDRESS</h3>
                        <div class="branch1">
                            <img src="<?php echo asset('app/views/user/home/img/location.png'); ?>" alt="location icon" class="icon-location">
                            <div class="branch1-address">
                                <span class="normal-text"><?php echo isset($visitUsData['address']) ? htmlspecialchars($visitUsData['address']) : ''; ?></span>
                                <span class="normal-text"><?php echo isset($visitUsData['phone']) ? htmlspecialchars($visitUsData['phone']) : ''; ?></span>
                                <span class="normal-text"><?php echo isset($visitUsData['email']) ? htmlspecialchars($visitUsData['email']) : ''; ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="working-hour">
                        <span class="title text-red">WORKING HOURS</span>
                        <span class="normal-text"><?php echo isset($visitUsData['working_hours_description']) ? htmlspecialchars($visitUsData['working_hours_description']) : ''; ?></span>
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
                <form action="contact/process.php" method="POST" id="contactForm">
                    <input type="hidden" name="userid" value="<?php echo isset($_SESSION['userid']) ? $_SESSION['userid'] : null; ?>">
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

                    <button type="submit" class="btn btn-primary btn-mini btn-submit">Get in touch</button>
                </form>
            </div>
        </section>


        <?php if ($result->num_rows > 0): ?>
            <div class="replies-section my-4">
                <h3 class="mb-4">Your Replies</h3>

                <?php while ($row = $result->fetch_assoc()): ?>
                    <div class="card mb-3 position-relative shadow-sm border-start border-4 border-success">
                        <div class="card-body">
                            <a href="?mark_read=<?= $row['ContactID'] ?>"
                                class="btn-close position-absolute top-0 end-0 m-3"
                                aria-label="Mark as read"></a>

                            <p class="mb-2"><strong>Your message:</strong><br>
                                <?= nl2br(htmlspecialchars($row['Message'])) ?>
                            </p>

                            <p class="mb-2"><strong>Admin replied:</strong><br>
                                <?= nl2br(htmlspecialchars($row['Reply'])) ?>
                            </p>

                            <p class="text-muted small mb-0"><em>Sent at: <?= $row['CreatedAt'] ?></em></p>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php elseif (isset($_SESSION['mySession'])): ?>
            <div class="alert alert-info mt-4">No replies yet or all replies have been read.</div>
        <?php endif; ?>


    </div>



</body>

</html>