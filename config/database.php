<?php

$host = "localhost";
$username = "root";
$password = "";
$database = "blog";

// Create connection
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Success message (only for testing)
echo "Database connected successfully!";
?>