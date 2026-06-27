<?php
session_start();
include "config/database.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$sql = "SELECT * FROM posts ORDER BY created_at DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Posts</title>
</head>

<body>

<h2>All Blog Posts</h2>

<a href="dashboard.php">⬅ Back to Dashboard</a>

<hr>

<?php

if ($result->num_rows > 0) {

    while($row = $result->fetch_assoc()) {

        echo "<h3>".$row['title']."</h3>";

        echo "<p>".$row['content']."</p>";

        echo "<small>Posted on: ".$row['created_at']."</small>";

        echo "<br><br>";

        echo "<a href='edit_post.php?id=".$row['id']."'>✏️ Edit</a>";

        echo " | ";

        echo "<a href='delete_post.php?id=".$row['id']."' onclick=\"return confirm('Delete this post?')\">🗑 Delete</a>";

        echo "<hr>";
    }

} else {

    echo "No posts available.";

}

?>

</body>
</html>