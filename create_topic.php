<?php
include 'dbconnect.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $user_id = $_SESSION['user_id'];

    $stmt = $conn->prepare("INSERT INTO topics (title, user_id) VALUES (?, ?)");
    $stmt->bind_param("si", $title, $user_id);
    if ($stmt->execute()) {
        header('Location: forum.php');
    } else {
        echo "Đã xảy ra lỗi trong khi tạo chủ đề.";
    }
    $stmt->close();
}
?> 
