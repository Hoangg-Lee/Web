<?php
// Kết nối cơ sở dữ liệu
include 'dbconnect.php';

// Khởi tạo session
session_start();

// Lấy ID chủ đề từ URL, đảm bảo ID là số nguyên
$topic_id = intval($_GET['id'] ?? 0);

// Lấy chi tiết chủ đề và bài viết từ cơ sở dữ liệu
$stmt = $conn->prepare("SELECT topics.title, users.username, topics.created_at,
                         posts.content, posts.created_at AS post_created_at
                         FROM topics
                         JOIN users ON topics.user_id = users.id
                         LEFT JOIN posts ON posts.topic_id = topics.id
                         WHERE topics.id = ?");
$stmt->bind_param("i", $topic_id);
$stmt->execute();
$result = $stmt->get_result();
$topic = $result->fetch_assoc();
$posts = $result->fetch_all(MYSQLI_ASSOC);
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
</head>
<body>
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
        <div class="topic-header">
            <h6><?= htmlspecialchars($topic['title'], ENT_QUOTES, 'UTF-8') ?></h6>
            <p class="content-text">Chủ đề bởi <?= htmlspecialchars($topic['username'], ENT_QUOTES, 'UTF-8') ?> vào <?= htmlspecialchars($topic['created_at'], ENT_QUOTES, 'UTF-8') ?></p>
        </div>
            <h6>Bài viết</h6>
            <div class="posts-container">
                <ul>
                    <?php foreach ($posts as $post): ?>
                        <li class="post-box"><?= htmlspecialchars($post['content'], ENT_QUOTES, 'UTF-8') ?> - bởi <?= htmlspecialchars($post['username'], ENT_QUOTES, 'UTF-8') ?> vào <?= htmlspecialchars($post['post_created_at'], ENT_QUOTES, 'UTF-8') ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <?php if (isset($_SESSION['username'])): ?>
                <h6 class="reply-header">Trả lời chủ đề</h6>
                <form action="create_post.php" method="post">
                    <input type="hidden" name="topic_id" value="<?= htmlspecialchars($topic_id, ENT_QUOTES, 'UTF-8') ?>">
                    <label class="content-label" for="content"></label><textarea name="content" placeholder="Nội dung bài viết" required></textarea></label>
                    <button type="submit" class="submit-button">Đăng bài</button>
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
