<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

include("config/database.php");

$message = "";

if (isset($_POST['submit'])) {

    $title = trim($_POST['title']);
    $content = trim($_POST['content']);

    // Server-side Validation
    if (empty($title) || empty($content)) {

        $message = "Please fill all fields.";

    } elseif (strlen($title) > 150) {

        $message = "Title cannot exceed 150 characters.";

    } else {

        // Prepared Statement
        $stmt = $conn->prepare("INSERT INTO posts (title, content) VALUES (?, ?)");

        $stmt->bind_param("ss", $title, $content);

        if ($stmt->execute()) {

            echo "<script>
                    alert('Post Published Successfully!');
                    window.location='view_posts.php';
                  </script>";
            exit();

        } else {

            $message = "Something went wrong.";

        }

        $stmt->close();
    }
}
?>

<?php include("includes/header.php"); ?>

<div class="container mt-5">

    <div class="row justify-content-center">

        <div class="col-lg-8">

            <div class="card shadow-lg border-0 rounded-4">

                <div class="card-body p-5">

                    <h2 class="text-primary mb-4">
                        📝 Create New Blog Post
                    </h2>

                    <?php if($message!=""){ ?>

                    <div class="alert alert-danger">

                        <?php echo $message; ?>

                    </div>

                    <?php } ?>

                    <form method="POST">

                        <div class="mb-4">

                            <label class="form-label fw-bold">
                                Blog Title
                            </label>

                            <input
                                type="text"
                                name="title"
                                class="form-control form-control-lg"
                                placeholder="Enter your blog title..."
                                required
                                maxlength="150">

                        </div>

                        <div class="mb-4">

                            <label class="form-label fw-bold">
                                Blog Content
                            </label>

                            <textarea
                                name="content"
                                class="form-control"
                                rows="8"
                                placeholder="Write your blog here..."
                                required></textarea>

                        </div>

                        <div class="d-flex gap-3">

                            <button
                                type="submit"
                                name="submit"
                                class="btn btn-success btn-lg">

                                ✅ Publish Post

                            </button>

                            <a
                                href="dashboard.php"
                                class="btn btn-secondary btn-lg">

                                ⬅ Back

                            </a>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

<?php include("includes/footer.php"); ?>