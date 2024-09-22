<?php
include 'dbconnect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Chuẩn bị và thực thi truy vấn kiểm tra xem email có tồn tại không
    $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Kiểm tra mật khẩu
        if (password_verify($password, $user['password'])) {
            // Đặt biến session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];

            // Chuyển hướng đến trang chủ hoặc diễn đàn
            header("Location: index.html");
            exit();
        } else {
            echo "Mật khẩu không đúng.";
        }
    } else {
        echo "Không tìm thấy người dùng với email này.";
    }
    $stmt->close();
}
$conn->close();
?>

<!-- Form đăng nhập -->
<h2>Đăng nhập</h2>
<form action="test.php" method="POST">
    <input type="email" name="email" placeholder="Email" required><br>
    <input type="password" name="password" placeholder="Mật khẩu" required><br>
    <input type="submit" value="Đăng nhập">
</form> 