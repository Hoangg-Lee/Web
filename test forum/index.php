<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forum</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Forum</h1>
    <a href="create_topic.php">Create New Topic</a>

    <?php
    include 'db_connect.php';

    $sql = "SELECT * FROM topics ORDER BY created_at DESC";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<div class='topic'>";
            echo "<h2><a href='view_topic.php?id=" . $row["id"] . "'>" . $row["title"] . "</a></h2>";
            echo "<p>Created by User ID: " . $row["user_id"] . " on " . $row["created_at"] . "</p>";
            echo "</div>";
        }
    } else {
        echo "<p>No topics available.</p>";
    }

    $conn->close();
    ?>
</body>
</html>
