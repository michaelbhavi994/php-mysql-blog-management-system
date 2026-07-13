<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

include "config/database.php";

$message = "";

// Validate ID
if (!isset($_GET["id"]) || !is_numeric($_GET["id"])) {
    die("Invalid Post ID.");
}

$id = (int)$_GET["id"];

// Fetch Post
$stmt = $conn->prepare("SELECT * FROM posts WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows == 0) {
    die("Post not found.");
}

$post = $result->fetch_assoc();

$stmt->close();


// Update Post

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $title = trim($_POST["title"]);
    $content = trim($_POST["content"]);

    if (empty($title) || empty($content)) {

        $message = "Please fill all fields.";

    } elseif (strlen($title) > 150) {

        $message = "Title cannot exceed 150 characters.";

    } else {

        $stmt = $conn->prepare(
            "UPDATE posts
            SET title=?, content=?
            WHERE id=?"
        );

        $stmt->bind_param("ssi",
            $title,
            $content,
            $id
        );

        if ($stmt->execute()) {

            header("Location: view_posts.php");
            exit();

        } else {

            $message = "Unable to update post.";

        }

        $stmt->close();

    }

}

include "includes/header.php";
?>

<div class="container mt-5">

<div class="row justify-content-center">

<div class="col-lg-8">

<div class="card shadow-lg p-5">

<h2 class="text-primary mb-4">

✏ Edit Blog Post

</h2>

<?php if($message!=""){ ?>

<div class="alert alert-danger">

<?php echo $message; ?>

</div>

<?php } ?>

<form method="POST">

<div class="mb-3">

<label class="form-label">

Title

</label>

<input
type="text"
name="title"
class="form-control"
required
maxlength="150"
value="<?php echo htmlspecialchars($post['title']); ?>">

</div>

<div class="mb-4">

<label class="form-label">

Content

</label>

<textarea
name="content"
rows="8"
class="form-control"
required><?php echo htmlspecialchars($post['content']); ?></textarea>

</div>

<button
class="btn btn-success">

Update Post

</button>

<a
href="view_posts.php"
class="btn btn-secondary">

Cancel

</a>

</form>

</div>

</div>

</div>

</div>

<?php include "includes/footer.php"; ?>