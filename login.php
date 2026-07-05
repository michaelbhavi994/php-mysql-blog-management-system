<?php
session_start();
include "config/database.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);

    $sql = "SELECT * FROM users WHERE username='$username'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {

        $user = $result->fetch_assoc();

        if (password_verify($password, $user["password"])) {

            $_SESSION["user_id"] = $user["id"];
            $_SESSION["username"] = $user["username"];

            header("Location: dashboard.php");
            exit();

        } else {
            $message = "Incorrect password!";
        }

    } else {
        $message = "User not found!";
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
                    required>

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
                    required>

                </div>

                <button
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