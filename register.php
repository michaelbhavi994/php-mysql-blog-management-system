<?php
include "config/database.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);

    if (!empty($username) && !empty($password)) {

        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Insert into database
        $sql = "INSERT INTO users (username, password)
                VALUES ('$username', '$hashedPassword')";

        if ($conn->query($sql) === TRUE) {
            $message = "Registration Successful!";
        } else {
            $message = "Error: " . $conn->error;
        }

    } else {
        $message = "Please fill all fields.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Registration</title>
</head>

<body>

<h2>Register</h2>

<form method="POST">

    <label>Username</label><br>
    <input type="text" name="username"><br><br>

    <label>Password</label><br>
    <input type="password" name="password"><br><br>

    <button type="submit">Register</button>

</form>

<p><?php echo $message; ?></p>

</body>
</html>