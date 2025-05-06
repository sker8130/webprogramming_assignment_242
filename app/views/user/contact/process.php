<?php
require_once __DIR__ . '/../../../config/config.php';
require_once __DIR__ . '/../../../database/database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $db = new Database();
    $conn = $db->connect();

    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $subject = $_POST['subject'] ?? '';
    $message = $_POST['message'];

    // Validate input
    if (empty($name) || empty($email) || empty($phone) || empty($message)) {
        die("Vui lòng điền đầy đủ thông tin");
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Email không hợp lệ");
    }

    // Save to database
    $stmt = $conn->prepare("INSERT INTO contacts (Name, Email, Phone, Subject, Message, Status) VALUES (?, ?, ?, ?, ?, 'pending')");
    $stmt->bind_param("sssss", $name, $email, $phone, $subject, $message);

    if ($stmt->execute()) {
        header("Location: ../contact/contact.php?success=1");
        exit();
    } else {
        die("Có lỗi xảy ra khi gửi liên hệ: " . $conn->error);
    }
} else {
    header("Location: ../contact/contact.php");
    exit();
}