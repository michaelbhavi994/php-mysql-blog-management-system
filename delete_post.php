<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

include "config/database.php";

// Validate ID
if (!isset($_GET["id"]) || !is_numeric($_GET["id"])) {
    die("Invalid Post ID.");
}

$id = (int)$_GET["id"];

// Prepared Statement
$stmt = $conn->prepare("DELETE FROM posts WHERE id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {

    header("Location: view_posts.php");
    exit();

} else {

    echo "Unable to delete post.";

}

$stmt->close();
$conn->close();
?>