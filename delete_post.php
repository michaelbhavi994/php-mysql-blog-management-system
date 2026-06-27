<?php
session_start();
include "config/database.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$id = $_GET['id'];

$sql = "DELETE FROM posts WHERE id=$id";

$conn->query($sql);

header("Location:view_posts.php");
exit();