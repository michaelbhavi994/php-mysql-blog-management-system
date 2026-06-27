<?php
session_start();
include "config/database.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$id = $_GET['id'];

$sql = "SELECT * FROM posts WHERE id=$id";
$result = $conn->query($sql);

$post = $result->fetch_assoc();

if($_SERVER["REQUEST_METHOD"]=="POST"){

    $title=$_POST["title"];
    $content=$_POST["content"];

    $sql="UPDATE posts SET title='$title', content='$content' WHERE id=$id";

    if($conn->query($sql)){
        header("Location:view_posts.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Edit Post</title>
</head>

<body>

<h2>Edit Blog Post</h2>

<form method="POST">

Title<br>

<input type="text" name="title"
value="<?php echo $post['title']; ?>">

<br><br>

Content<br>

<textarea name="content" rows="8" cols="50"><?php echo $post['content']; ?></textarea>

<br><br>

<button type="submit">Update Post</button>

</form>

</body>
</html>