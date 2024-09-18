<?php
// Kết nối đến cơ sở dữ liệu
include 'dbconnect.php';

// Khởi tạo session
session_start();

// Lấy tất cả các chủ đề từ cơ sở dữ liệu cùng với thông tin người tạo chủ đề, sắp xếp theo thời gian tạo chủ đề giảm dần
$stmt = $conn->query("SELECT topics.id, topics.title, users.username, topics.created_at 
                     FROM topics 
                     JOIN users ON topics.user_id = users.id
                     ORDER BY topics.created_at DESC");

// Fetch dữ liệu và lưu vào mảng associative
$topics = $stmt->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Diễn đàn Game</title>
    <!-- Liên kết đến các file CSS cần thiết -->
    <link rel="stylesheet" href="forum.css">
    <link rel="stylesheet" href="globe.css">
    <link rel="stylesheet" href="style.css">
    <!-- Biểu tượng favicon -->
    <link rel="shortcut icon" href="/code/img/Mot_Chut_Fact_logo_chen_vid.png" type="image/x-icon">
    <!-- Liên kết Font Awesome để sử dụng biểu tượng -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" 
    integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" 
    crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        /* CSS để định dạng video nền */
        .video-background {
            position: fixed; /* Dùng fixed để video luôn ở phía dưới và không bị cuộn */
            top: 0;
            left: 0;
            width: 100%; /* Đặt chiều rộng video chiếm toàn bộ chiều rộng của viewport */
            height: 100%; /* Đặt chiều cao video chiếm toàn bộ chiều cao của viewport */
            object-fit: cover; /* Đảm bảo video phủ toàn bộ khung mà không bị biến dạng */
            z-index: -1; /* Đặt video dưới các phần tử khác để không che khuất nội dung */
            pointer-events: none; /* Ngăn video nhận các sự kiện chuột để không ảnh hưởng đến các phần tử khác */
        }

        /* Đảm bảo nội dung nằm trên video */
        main {
            position: relative;
            z-index: 1;
            color: #fff; /* Màu chữ trắng để nổi bật trên video */
            padding: 20px;
        }

        /* Định dạng cho các phần tử tiêu đề */
        h2 {
            margin-top: 0; /* Loại bỏ khoảng cách phía trên tiêu đề */
            color: #fff; /* Màu chữ trắng để đồng nhất với nội dung */
        }

        /* Định dạng cho các phần tử form */
        form {
            margin-top: 20px; /* Khoảng cách giữa form và nội dung phía trên */
        }

        input[type="text"], button {
            padding: 10px; /* Khoảng cách bên trong input và button */
            border: 1px solid #ccc; /* Đường viền nhẹ cho input */
            border-radius: 4px; /* Bo góc mềm mại cho input và button */
        }

        button {
            background-color: #007bff; /* Màu nền xanh dương cho nút */
            color: #fff; /* Màu chữ trắng để tương phản với màu nền */
            border: none; /* Loại bỏ viền mặc định của nút */
            cursor: pointer; /* Thay đổi con trỏ chuột khi hover qua nút */
        }

        button:hover {
            background-color: #0056b3; /* Thay đổi màu nền khi hover để tạo hiệu ứng tương tác */
        }

        ul {
            list-style: none; /* Loại bỏ ký hiệu chấm đầu dòng của danh sách */
            padding: 0; /* Loại bỏ khoảng cách thụt lề của danh sách */
        }

        li {
            margin-bottom: 10px; /* Tạo khoảng cách giữa các mục trong danh sách */
            color: #fff; /* Đặt màu chữ trắng cho mục danh sách để nổi bật trên video tối */
        }

        a {
            color: #fff; /* Màu liên kết trắng để nổi bật trên nền video */
            text-decoration: none; /* Loại bỏ gạch chân khỏi liên kết */
        }

        a:hover {
            text-decoration: underline; /* Thêm gạch chân khi hover qua liên kết để tạo hiệu ứng tương tác */
        }
    </style>
</head>
<body>
    <!-- Video Background -->
    <video class="video-background" autoplay muted loop>
        <source src="img/vid.mp4" type="video/mp4">
        Your browser does not support the video tag.
    </video>
    
    <!-- Điều hướng -->
    <div class="logo">
        <h1>
            <a href="index.html">Game<span>1</span></a>
        </h1>
    </div>


    <!-- Nội dung chính -->
    <main>
    <section class="welcome-section">
        <!-- Kiểm tra xem người dùng đã đăng nhập chưa -->
        <?php if (isset($_SESSION['username'])): ?>
            <p>Chào mừng, <?= htmlspecialchars($_SESSION['username'], ENT_QUOTES, 'UTF-8') ?>! 
            <a href="logout.php">Đăng xuất</a></p>
            
            <!-- Form tạo chủ đề mới chỉ hiển thị khi người dùng đăng nhập -->
            <h2>Tạo chủ đề mới</h2>
            <form action="create_topic.php" method="post">
                <input type="text" name="title" placeholder="Tiêu đề chủ đề" required>
                <button type="submit">Tạo chủ đề</button>
            </form>
    </section>
        <?php else: ?>
            <!-- Thông báo mời người dùng đăng nhập hoặc đăng ký nếu chưa đăng nhập -->
            <section class="login-prompt">
            <p><a href="login.php">Đăng nhập</a> hoặc <a href="register.php">Đăng ký</a> để tham gia.</p>
            </section> 
        <?php endif; ?>

        <!-- Danh sách các chủ đề hiện có -->
        <section class="topics-section">
        <h2>Danh sách chủ đề</h2>
        <ul>
            <?php foreach ($topics as $topic): ?>
                <li>
                    <!-- Hiển thị tiêu đề chủ đề và thông tin người đăng cùng thời gian tạo -->
                    <a href="topic.php?id=<?= htmlspecialchars($topic['id'], ENT_QUOTES, 'UTF-8') ?>">
                        <?= htmlspecialchars($topic['title'], ENT_QUOTES, 'UTF-8') ?>
                    </a> 
                    bởi <?= htmlspecialchars($topic['username'], ENT_QUOTES, 'UTF-8') ?> vào 
                    <?= htmlspecialchars($topic['created_at'], ENT_QUOTES, 'UTF-8') ?>
                </li>
            <?php endforeach; ?>
        </ul>
        </section>
    </div>
    </main>
    <!-- Chân trang -->
    <footer>
        <div class="row">
            <div class="col">
                <img src="img/Mot_Chut_Fact_logo_chen_vid.png" alt="Logo" class="logo">
                <p>Giới thiệu và mô tả nội dung</p>
            </div>
            <div class="col">
                <h3>Địa chỉ:</h3>
                <p>Nhà thg Hoang</p>
                <p>Hà Nội</p>
                <p class="email-id">thitcho@web.com</p>
                <h4>0123124451</h4>
            </div>
            <div class="col">
                <h3>Links</h3>
                <ul>
                    <li><a href="index.html">Home</a></li>
                    <li><a href="about.html">About</a></li>
                    <li><a href="#">Blogs</a></li>
                </ul>
            </div>
            <div class="col">
                <h3>Socials</h3>
                <div class="nav2 flex">
                    <div class="icons flex">
                        <i class="fa-solid fa-magnifying-glass"></i>
                        <i class="fa-brands fa-facebook"></i>
                        <i class="fa-brands fa-youtube"></i>
                        <i class="fa-brands fa-instagram"></i>
                        <i class="fa-brands fa-twitch"></i>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>