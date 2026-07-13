<?php
include "config/database.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);

    // Server-side Validation
    if (empty($username) || empty($password)) {

        $message = "Please fill all fields.";

    } elseif (strlen($username) < 3) {

        $message = "Username must be at least 3 characters.";

    } elseif (strlen($password) < 6) {

        $message = "Password must be at least 6 characters.";

    } else {

        // Check if username already exists
        $check = $conn->prepare("SELECT id FROM users WHERE username = ?");
        $check->bind_param("s", $username);
        $check->execute();
        $check->store_result();

        if ($check->num_rows > 0) {

            $message = "Username already exists.";

        } else {

            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Prepared Statement
            $stmt = $conn->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, 'editor')");
            $stmt->bind_param("ss", $username, $hashedPassword);

            if ($stmt->execute()) {

                $message = "Registration Successful! You can now login.";

            } else {

                $message = "Something went wrong.";

            }

            $stmt->close();
        }

        $check->close();
    }
}

include "includes/header.php";
?>

<div class="row justify-content-center mt-5">

<div class="col-md-5">

<div class="card shadow-lg p-4">

<h2 class="text-center text-success mb-4">

👤 Create Account

</h2>

<?php if($message!=""){ ?>

<div class="alert alert-info">

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
placeholder="Choose username"
required
minlength="3"
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
placeholder="Choose password"
required
minlength="6"
maxlength="50"
autocomplete="new-password">

</div>

<button
type="submit"
class="btn btn-success w-100">

Create Account

</button>

</form>

<hr>

<p class="text-center">

Already have an account?

<a href="login.php">

Login

</a>

</p>

</div>

</div>

</div>

<?php include "includes/footer.php"; ?>