<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'forum');

// Kiểm tra người dùng đã đăng nhập chưa
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Xử lý đăng bài mới
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['new_post'])) {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $game_title = $_POST['game_title'];
    $user_id = $_SESSION['user_id'];

    $stmt = $conn->prepare("INSERT INTO posts (user_id, title, content, game_title) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("isss", $user_id, $title, $content, $game_title);
    $stmt->execute();
    $stmt->close();
}

// Lấy danh sách các bài viết về game
$posts = $conn->query("SELECT posts.id, posts.title, posts.game_title, users.username, posts.created_at FROM posts JOIN users ON posts.user_id = users.id ORDER BY posts.created_at DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Game Forum</title>
</head>
<body>
    <h2>Game Forum</h2>
    <!-- Form đăng bài mới -->
    <form action="forum.php" method="POST">
        <input type="text" name="game_title" placeholder="Game Title" required><br>
        <input type="text" name="title" placeholder="Post Title" required><br>
        <textarea name="content" placeholder="Post Content" required></textarea><br>
        <input type="submit" name="new_post" value="Create Post">
    </form>

    <!-- Danh sách các bài viết về game -->
    <h3>Recent Posts</h3>
    <ul>
        <?php while ($post = $posts->fetch_assoc()): ?>
            <li>
                <a href="post.php?id=<?php echo $post['id']; ?>"><?php echo htmlspecialchars($post['title']); ?></a>
                about <?php echo htmlspecialchars($post['game_title']); ?>
                by <?php echo htmlspecialchars($post['username']); ?> on <?php echo $post['created_at']; ?>
            </li>
        <?php endwhile; ?>
    </ul>
</body>
</html>
<?php $conn->close(); ?>