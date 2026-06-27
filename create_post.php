<?php
session_start();
include "config/database.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $title = trim($_POST["title"]);
    $content = trim($_POST["content"]);

    if (!empty($title) && !empty($content)) {

        $sql = "INSERT INTO posts (title, content) VALUES ('$title', '$content')";

        if ($conn->query($sql) === TRUE) {
            $message = "✅ Post created successfully!";
        } else {
            $message = "❌ Error: " . $conn->error;
        }

    } else {
        $message = "⚠ Please fill in all fields.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Post</title>
</head>

<body>

<h2>Create New Blog Post</h2>

<form method="POST">

    <label>Title</label><br>
    <input type="text" name="title" required>
    <br><br>

    <label>Content</label><br>
    <textarea name="content" rows="8" cols="50" required></textarea>
    <br><br>

    <button type="submit">Publish Post</button>

</form>

<br>

<p><?php echo $message; ?></p>

<hr>

<a href="dashboard.php">⬅ Back to Dashboard</a> |
<a href="view_posts.php">📄 View All Posts</a>

</body>
</html>