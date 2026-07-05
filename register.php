<?php
include "config/database.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);

    if (!empty($username) && !empty($password)) {

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO users(username,password)
                VALUES('$username','$hashedPassword')";

        if($conn->query($sql)==TRUE){

            $message="Registration Successful!";

        }else{

            $message="Error : ".$conn->error;

        }

    }else{

        $message="Please fill all fields.";

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

<?php

if($message!=""){

?>

<div class="alert alert-info">

<?php echo $message; ?>

</div>

<?php

}

?>

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
placeholder="Choose password"
required>

</div>

<button
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