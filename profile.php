<?php
include 'dbconnect.php';
session_start();

// Kiểm tra người dùng đã đăng nhập chưa
if (!isset($_SESSION['id'])) {
    header('Location: login.php'); // Chuyển hướng đến trang đăng nhập nếu chưa đăng nhập
    exit;
}

$user_id = $_SESSION['id'];

// Lấy thông tin người dùng từ cơ sở dữ liệu
$stmt = $conn->prepare("SELECT username, email, bio, avatar FROM users WHERE id = ?");
if ($stmt === false) {
    die("Lỗi trong quá trình chuẩn bị câu lệnh SQL: " . $conn->error);
}
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($user) {
    // Gán avatar nếu có, ngược lại sử dụng ảnh mặc định
    $avatar = $user['avatar'] ? 'img/' . $user['avatar'] : 'img/default.png';
} else {
    echo "Không tìm thấy thông tin người dùng.";
    exit;
}

// Xử lý khi người dùng gửi form chỉnh sửa thông tin cá nhân
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $new_username = $_POST['username'];
    $new_email = $_POST['email'];
    $new_bio = $_POST['bio'];

    // Cập nhật thông tin người dùng (username, email, bio)
    $update_stmt = $conn->prepare("UPDATE users SET username = ?, email = ?, bio = ? WHERE id = ?");
    $update_stmt->bind_param("sssi", $new_username, $new_email, $new_bio, $user_id);

    if ($update_stmt->execute()) {
        echo "Thông tin đã được cập nhật thành công.<br>";
        // Cập nhật lại thông tin trong $user sau khi lưu
        $user['username'] = $new_username;
        $user['email'] = $new_email;
        $user['bio'] = $new_bio;
    } else {
        echo "Có lỗi xảy ra khi cập nhật thông tin.<br>";
    }

    // Xử lý cập nhật avatar
    if (!empty($_FILES['avatar']['name'])) {
        $target_dir = "img/";
        $target_file = $target_dir . basename($_FILES["avatar"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Kiểm tra xem file có phải là ảnh không
        $check = getimagesize($_FILES["avatar"]["tmp_name"]);
        if ($check !== false) {
            if (move_uploaded_file($_FILES["avatar"]["tmp_name"], $target_file)) {
                // Cập nhật đường dẫn avatar trong cơ sở dữ liệu
                $update_stmt = $conn->prepare("UPDATE users SET avatar = ? WHERE id = ?");
                $update_stmt->bind_param("si", $target_file, $user_id);
                if ($update_stmt->execute()) {
                    $user['avatar'] = $target_file;
                    echo "Avatar đã được cập nhật thành công.<br>";
                }
            } else {
                echo "Có lỗi khi tải lên ảnh.<br>";
            }
        } else {
            echo "File không phải là ảnh hợp lệ.<br>";
        }
    }
}
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
    <p><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></p>
    <p><strong>Tiểu sử:</strong> <?= htmlspecialchars($user['bio']) ?></p>

    <!-- Form chỉnh sửa thông tin cá nhân -->
    <h2>Chỉnh sửa thông tin cá nhân</h2>
    <form method="POST" action="profile.php" enctype="multipart/form-data">
        <div>
            <label for="username">Tên người dùng:</label>
            <input type="text" id="username" name="username" value="<?= htmlspecialchars($user['username']) ?>" required>
        </div>
        <div>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>
        </div>
        <div>
            <label for="bio">Tiểu sử:</label>
            <textarea id="bio" name="bio" rows="4" cols="50"><?= htmlspecialchars($user['bio']) ?></textarea>
        </div>
        <div>
            <label for="avatar">Thay đổi Avatar:</label>
            <input type="file" id="avatar" name="avatar">
        </div>
        <div>
            <button type="submit">Lưu thay đổi</button>
        </div>
    </form>

    <!-- Nút đăng xuất -->
    <p><a href="logout.php">Đăng xuất</a></p>
</body>
</html>
