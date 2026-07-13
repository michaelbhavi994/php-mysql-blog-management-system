<?php
session_start();
include "config/database.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);

    // Server-side Validation
    if (empty($username) || empty($password)) {
        $message = "Please fill in all fields.";
    } else {

        // Prepared Statement
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows == 1) {

            $user = $result->fetch_assoc();

            if (password_verify($password, $user["password"])) {

                $_SESSION["user_id"] = $user["id"];
                $_SESSION["username"] = $user["username"];
                $_SESSION["role"] = $user["role"];

                header("Location: dashboard.php");
                exit();

            } else {

                $message = "Incorrect password.";

            }

        } else {

            $message = "User not found.";

        }

        $stmt->close();
    }
}

include "includes/header.php";
?>

<div class="row justify-content-center mt-5">

<div class="col-md-5">

<div class="card shadow-lg p-4">

<h2 class="text-center text-primary mb-4">
🔐 Login
</h2>

<?php if($message!=""){ ?>

<div class="alert alert-danger">

<?php echo $message; ?>

</div>

<?php } ?>

<form method="POST">

<div class="mb-3">

<label class="form-label">

Username

</label>

<input
type="text"
name="username"
class="form-control"
placeholder="Enter username"
required
maxlength="30"
autocomplete="username">

</div>

<div class="mb-4">

<label class="form-label">

Password

</label>

<input
type="password"
name="password"
class="form-control"
placeholder="Enter password"
required
minlength="6"
autocomplete="current-password">

</div>

<button
type="submit"
class="btn btn-primary w-100">

Login

</button>

</form>

<hr>

<p class="text-center">

Don't have an account?

<a href="register.php">

Register Here

</a>

</p>

</div>

</div>

</div>

<?php include "includes/footer.php"; ?>