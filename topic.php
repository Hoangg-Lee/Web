<?php
// Kết nối cơ sở dữ liệu
include 'dbconnect.php';

// Khởi tạo session
session_start();

// Lấy ID chủ đề từ URL, đảm bảo ID là số nguyên
$topic_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Lấy chi tiết chủ đề từ cơ sở dữ liệu
$stmt = $conn->prepare("SELECT topics.title, users.username, topics.created_at
                       FROM topics
                       JOIN users ON topics.user_id = users.id
                       WHERE topics.id = ?");
$stmt->bind_param("i", $topic_id);
$stmt->execute();
$topic = $stmt->get_result()->fetch_assoc();

// Lấy các bài viết trong chủ đề
$stmt = $conn->prepare("SELECT posts.content, users.username, posts.created_at 
                       FROM posts 
                       JOIN users ON posts.user_id = users.id 
                       WHERE posts.topic_id = ? 
                       ORDER BY posts.created_at ASC");
$stmt->bind_param("i", $topic_id);
$stmt->execute();
$posts = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($topic['title'], ENT_QUOTES, 'UTF-8') ?></title>
    <link rel="stylesheet" href="topic.css">
    <link rel="stylesheet" href="globle.css">
    <link rel="stylesheet" href="style.css">
    <link rel="shortcut icon" href="/code/img/Mot_Chut_Fact_logo_chen_vid.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" 
    integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" 
    crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        /* CSS để định dạng video nền */
        .video-background {
            position: fixed; /* Dùng fixed để video luôn ở phía dưới và không bị cuộn */
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover; /* Đảm bảo video phủ toàn bộ khung */
            z-index: -1; /* Đặt video dưới các phần tử khác */
            pointer-events: none; /* Ngăn video nhận các sự kiện chuột */
        }

        /* Đảm bảo nội dung nằm trên video */
        main {
            position: relative;
            z-index: 1;
            color: #fff; /* Màu chữ trắng để nổi bật trên video */
            padding: 20px;
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
    <nav class="container">
        <div class="logo">
            <h1><a href="#">Game<span>1</span></a></h1>
        </div>  

        <div class="navlist">
            <ul class="flex">
                <li><a href="index.html">Home</a></li>
                <li><a href="about.html">About</a></li>
                <li><a href="/">Forum</a></li>
                <li><a href="/">Games <i class="fa-solid fa-angle-down"></i></a></li>
            </ul>
        </div>

        <div class="icons flex">
            <i class="fa-solid fa-magnifying-glass"></i>
            <i class="fa-brands fa-facebook"></i>
            <i class="fa-brands fa-youtube"></i>
            <i class="fa-brands fa-instagram"></i>
            <i class="fa-brands fa-twitch"></i>
        </div>
    </nav>

    <!-- Nội dung chính -->
    <main>
    <div class="content-container">
        <h6><?= htmlspecialchars($topic['title'], ENT_QUOTES, 'UTF-8') ?></h6>
        <p class="content-text">Chủ đề bởi <?= htmlspecialchars($topic['username'], ENT_QUOTES, 'UTF-8') ?> vào <?= htmlspecialchars($topic['created_at'], ENT_QUOTES, 'UTF-8') ?></p>

        <h6>Bài viết</h6>
        <ul>
            <?php foreach ($posts as $post): ?>
                <li>
                    <?= htmlspecialchars($post['content'], ENT_QUOTES, 'UTF-8') ?> - bởi <?= htmlspecialchars($post['username'], ENT_QUOTES, 'UTF-8') ?> vào <?= htmlspecialchars($post['created_at'], ENT_QUOTES, 'UTF-8') ?>
                </li>
            <?php endforeach; ?>
        </ul>

        <?php if (isset($_SESSION['username'])): ?>
            <!-- Form thêm bài viết mới -->
            <h6>Trả lời chủ đề</h6>
            <form action="create_post.php" method="post">
                <input type="hidden" name="topic_id" value="<?= htmlspecialchars($topic_id, ENT_QUOTES, 'UTF-8') ?>">
                <textarea name="content" placeholder="Nội dung bài viết" required></textarea><br>
                <button type="submit">Đăng bài</button>
            </form>
        <?php else: ?>
            <p class="content-text"><a href="login.php">Đăng nhập</a> để trả lời.</p>
        <?php endif; ?>
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
