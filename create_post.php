<?php
include 'dbconnect.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $content = $_POST['content'];
    $topic_id = $_POST['topic_id'];
    $user_id = $_SESSION['user_id'];
    
    $stmt = $conn->prepare("INSERT INTO posts (content, topic_id, user_id) VALUES (?, ?, ?)");
    $stmt->bind_param("sii", $content, $topic_id, $user_id);
    if ($stmt->execute()) {
        header("Location: topic.php?id=$topic_id");
    } else {
        echo "Đã xảy ra lỗi khi đăng bài.";
    }
    $stmt->close();
}
?>