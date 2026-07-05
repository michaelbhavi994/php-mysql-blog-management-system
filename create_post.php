<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

include("config/database.php");

if (isset($_POST['submit'])) {

    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $content = mysqli_real_escape_string($conn, $_POST['content']);

    $sql = "INSERT INTO posts(title, content) VALUES('$title','$content')";

    if (mysqli_query($conn, $sql)) {
        echo "<script>
                alert('Post Published Successfully!');
                window.location='view_posts.php';
              </script>";
    } else {
        echo "<div class='alert alert-danger'>Error: " . mysqli_error($conn) . "</div>";
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
                                required>

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