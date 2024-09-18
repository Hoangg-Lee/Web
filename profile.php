<?php
include 'dbconnect.php';
session_start();

// Kiểm tra người dùng đã đăng nhập chưa
if (!isset($_SESSION['id'])) {
    header('Location: profile.php');
    exit;
}

$user_id = $_SESSION['id'];

// Lấy thông tin người dùng từ cơ sở dữ liệu
$stmt = $conn->prepare("SELECT username, gmail, avatar FROM users WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

$avatar = $user['avatar'] ? 'uploads/' . $user['avatar'] : 'uploads/default.png';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Thông tin cá nhân</title>
</head>
<body>
    <h1>Thông tin cá nhân của bạn</h1>

    <!-- Hiển thị avatar người dùng -->
    <img src="<?= $avatar ?>" alt="Avatar" style="width: 150px; height: 150px;"><br>

    <!-- Hiển thị thông tin người dùng -->
    <p><strong>Tên đăng nhập:</strong> <?= htmlspecialchars($user['username']) ?></p>
    <p><strong>Email:</strong> <?= htmlspecialchars($user['gmail']) ?></p>

    <!-- Nút chuyển đến trang cập nhật thông tin -->
    <a href="edit_profile.php">Cập nhật thông tin</a>

    <p><a href="forum.php">Quay lại trang chủ</a></p>
</body>
</html>