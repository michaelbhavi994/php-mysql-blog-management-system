<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

include "config/database.php";

// Count total posts
$result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM posts");
$row = mysqli_fetch_assoc($result);
$totalPosts = $row['total'];

include "includes/header.php";
?>

<div class="card shadow-lg p-4">

    <h2 class="text-primary">
        👋 Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>
    </h2>

    <p class="text-muted">
        Manage your blog posts from one place.
    </p>

    <hr>

    <div class="row text-center mb-4">

        <div class="col-md-4 mb-3">
            <div class="card shadow-sm p-3">
                <h5>📚 Total Posts</h5>
                <h2 class="text-primary"><?php echo $totalPosts; ?></h2>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="card shadow-sm p-3">
                <h5>📅 Today's Date</h5>
                <p><?php echo date("d M Y"); ?></p>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="card shadow-sm p-3">
                <h5>👤 Logged In As</h5>
                <p><?php echo htmlspecialchars($_SESSION['username']); ?></p>
            </div>
        </div>

    </div>

    <div class="d-flex flex-wrap gap-3 justify-content-center">

        <a href="create_post.php" class="btn btn-success btn-lg">
            ➕ Create Post
        </a>

        <a href="view_posts.php" class="btn btn-primary btn-lg">
            📚 View Posts
        </a>

        <a href="logout.php" class="btn btn-danger btn-lg">
            🚪 Logout
        </a>

    </div>

</div>

<?php include "includes/footer.php"; ?>