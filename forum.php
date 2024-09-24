<?php
// Kết nối đến cơ sở dữ liệu
include 'dbconnect.php';
session_start();

// Lấy tất cả các chủ đề từ cơ sở dữ liệu
$stmt = $conn->prepare("SELECT topics.id, topics.title, users.username, topics.created_at 
                         FROM topics 
                         JOIN users ON topics.user_id = users.id
                         ORDER BY topics.created_at DESC");
$stmt->execute();
$topics = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Diễn đàn Game</title>
    <link rel="stylesheet" href="forum.css">
    <link rel="stylesheet" href="style.css">
    <link rel="shortcut icon" href="/code/img/Mot_Chut_Fact_logo_chen_vid.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
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
                <li><a href="forum.php">Forums</a></li>
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

    <main>
        <div class="content-table">
            <div class="main-content">
                <section class="welcome-section">
                    <?php if (isset($_SESSION['username'])): ?>
                        <div class="welcome-message">
                            <p><?= htmlspecialchars($_SESSION['username'], ENT_QUOTES, 'UTF-8') ?></p>
                            <a href="logout.php" class="logout-button">Đăng xuất</a>
                        </div>
                        <h2>Tạo chủ đề mới</h2>
                        <form action="create_topic.php" method="post" class="create-topic-form">
                            <input type="text" name="title" placeholder="Tiêu đề chủ đề" required>
                            <button type="submit">Tạo</button>
                        </form>
                    <?php else: ?>
                        <p><a href="login.php">Đăng nhập</a> hoặc <a href="register.php">Đăng ký</a> để tham gia.</p>
                    <?php endif; ?>
                </section>

                <section class="topics-section">
                    <h2>Danh sách chủ đề</h2>
                    <ul class="topics-list">
                        <?php foreach ($topics as $topic): ?>
                            <li class="topic-box">
                                <a href="topic.php?id=<?= htmlspecialchars($topic['id'], ENT_QUOTES, 'UTF-8') ?>">
                                    <?= htmlspecialchars($topic['title'], ENT_QUOTES, 'UTF-8') ?>
                                </a>
                                <br>
                                <span class="meta-info">bởi <?= htmlspecialchars($topic['username'], ENT_QUOTES, 'UTF-8') ?> vào <?= htmlspecialchars($topic['created_at'], ENT_QUOTES, 'UTF-8') ?></span>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </section>
            </div>
        </div>
    </main>

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
                    <li><a href="login.php">Forums</a></li>
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
