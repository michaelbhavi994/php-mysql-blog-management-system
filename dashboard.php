<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>

<body>

<h1>Welcome <?php echo $_SESSION["username"]; ?> 🎉</h1>

<p>You have successfully logged in.</p>

<hr>

<a href="create_post.php">➕ Create New Post</a>

<br><br>

<a href="view_posts.php">📄 View All Posts</a>

<br><br>

<a href="logout.php">🚪 Logout</a>

</body>
</html>