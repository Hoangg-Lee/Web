<?php
include 'dbconnect.php';
session_start();

$topic_id = $_GET['id'];

// Lấy chi tiết chủ đề
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
<html>
<head>
    <title><?= htmlspecialchars($topic['title']) ?></title>
</head>
<body>
    <h1><?= htmlspecialchars($topic['title']) ?></h1>
    <p>Chủ đề bởi <?= htmlspecialchars($topic['username']) ?> vào <?= $topic['created_at'] ?></p>

    <h2>Bài viết</h2>
    <ul>
        <?php foreach ($posts as $post): ?>
            <li>
                <?= htmlspecialchars($post['content']) ?> - bởi <?= htmlspecialchars($post['username']) ?> vào <?= $post['created_at'] ?>
            </li>
        <?php endforeach; ?>
    </ul>

    <?php if (isset($_SESSION['username'])): ?>
        <!-- Form thêm bài viết mới -->
        <h3>Trả lời chủ đề</h3>
        <form action="create_post.php" method="post">
            <input type="hidden" name="topic_id" value="<?= $topic_id ?>">
            <textarea name="content" placeholder="Nội dung bài viết" required></textarea><br>
            <button type="submit">Đăng bài</button>
        </form>
    <?php else: ?>
        <p><a href="login.php">Đăng nhập</a> để trả lời.</p>
    <?php endif; ?>
</body>
</html>