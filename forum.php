<?php
include 'dbconnect.php';

// Lấy tất cả các chủ đề từ cơ sở dữ liệu
$stmt = $conn->query("SELECT topics.id, topics.title, users.username, topics.created_at 
                     FROM topics 
                     JOIN users ON topics.user_id = users.id
                     ORDER BY topics.created_at DESC");
$topics = $stmt->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us</title>
    <link rel="stylesheet" href="forum.css">
    <link rel="stylesheet" href="globe.css">
    <link rel="shortcut icon" href="/code/img/Mot_Chut_Fact_logo_chen_vid.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" 
    integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" 
    crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Diễn đàn Game</title>
</head>
<body>
    <header>
        <div class="logo">
            <h1>
                <a href="index.html">Game<span>1</span></a>
                <b>Diễn đàn game</b>
            </h1>   
        </div> 
    </header>

    
    <!-- Kiểm tra xem người dùng đã đăng nhập chưa -->
    <?php if (isset($_SESSION['username'])): ?>
        <p>Chào mừng, <?= $_SESSION['username'] ?>! <a href="logout.php">Đăng xuất</a></p>
        
        <!-- Form tạo chủ đề mới -->
        <h2>Tạo chủ đề mới</h2>
        <form action="create_topic.php" method="post">
            <input type="text" name="title" placeholder="Tiêu đề chủ đề" required><br>
            <button type="submit">Tạo chủ đề</button>
        </form>
    <?php else: ?>
        <p><a href="login.php">Đăng nhập</a> hoặc <a href="register.php">Đăng ký</a> để tham gia.</p>
    <?php endif; ?>

    <h2>Danh sách chủ đề</h2>
    <ul>
        <?php foreach ($topics as $topic): ?>
            <li>
                <a href="topic.php?id=<?= $topic['id'] ?>"><?= htmlspecialchars($topic['title']) ?></a> 
                bởi <?= htmlspecialchars($topic['username']) ?> vào <?= $topic['created_at'] ?>
            </li>
        <?php endforeach; ?>
    </ul>
</body>
</html>