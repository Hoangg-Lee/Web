<?php
include 'db_connect.php';

session_start();

// Kiểm tra người dùng đã đăng nhập
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$title = $_POST['title'];
$content = $_POST['content'];
$user_id = $_SESSION['user_id'];

// Tạo chủ đề mới
$sql = "INSERT INTO topics (title, user_id) VALUES (?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("si", $title, $user_id);
$stmt->execute();
$topic_id = $conn->insert_id;

// Tạo bài viết đầu tiên cho chủ đề
$sql = "INSERT INTO posts (topic_id, user_id, content) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iis", $topic_id, $user_id, $content);
$stmt->execute();

$conn->close();

header("Location: view_topic.php?id=" . $topic_id);
exit();
?>
