<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Topic</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1>Create New Topic</h1>
    <form action="create_topic_process.php" method="post">
        <label for="title">Title:</label>
        <input type="text" id="title" name="title" required>
        
        <label for="content">Content:</label>
        <textarea id="content" name="content" required></textarea>
        
        <button type="submit">Create Topic</button>
    </form>
</body>
</html>
