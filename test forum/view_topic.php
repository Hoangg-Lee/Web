<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Topic</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php
    include 'db_connect.php';

    $topic_id = intval($_GET['id']);

    // Lấy thông tin chủ đề
    $sql = "SELECT * FROM topics WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $topic_id);
    $stmt->execute();
    $topic_result = $stmt->get_result()->fetch_assoc();

    // Hiển thị chủ đề
    echo "<h1>" . $topic_result["title"] . "</h1>";
    echo "<p>Created by User ID: " . $topic_result["user_id"] . " on " . $topic_result["created_at"] . "</p>";

    // Lấy các bài viết
    $sql = "SELECT * FROM posts WHERE topic_id = ? ORDER BY created_at DESC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $topic_id);
    $stmt->execute();
    $posts_result = $stmt->get_result();

    if ($posts_result->num_rows > 0) {
        while ($post = $posts_result->fetch_assoc()) {
            echo "<div class='post'>";
            echo "<p>User ID: " . $post["user_id"] . " on " . $post["created_at"] . "</p>";
            echo "<p>" . $post["content"] . "</p>";
            echo "</div>";
        }
    } else {
        echo "<p>No posts yet.</p>";
    }

    $conn->close();
    ?>
</body>
</html>
