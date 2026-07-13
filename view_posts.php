<?php
session_start();
include "config/database.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$search = "";

if (isset($_GET['search'])) {
    $search = trim($_GET['search']);
}

$limit = 5;

$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;

$start = ($page - 1) * $limit;

$searchTerm = "%" . $search . "%";

/* COUNT POSTS */

$countStmt = $conn->prepare("
SELECT COUNT(*) AS total
FROM posts
WHERE title LIKE ?
OR content LIKE ?
");

$countStmt->bind_param("ss", $searchTerm, $searchTerm);

$countStmt->execute();

$countResult = $countStmt->get_result();

$totalPosts = $countResult->fetch_assoc()['total'];

$totalPages = ceil($totalPosts / $limit);

$countStmt->close();


/* FETCH POSTS */

$stmt = $conn->prepare("
SELECT *
FROM posts
WHERE title LIKE ?
OR content LIKE ?
ORDER BY created_at DESC
LIMIT ?, ?
");

$stmt->bind_param("ssii", $searchTerm, $searchTerm, $start, $limit);

$stmt->execute();

$result = $stmt->get_result();

include "includes/header.php";
?>

<div class="container mt-4">

<div class="card shadow p-4 mb-4">

<h2 class="text-primary mb-3">
📚 Blog Posts
</h2>

<form method="GET">

<div class="input-group">

<input
type="text"
class="form-control"
name="search"
placeholder="Search by title or content..."
maxlength="100"
value="<?php echo htmlspecialchars($search); ?>">

<button class="btn btn-primary">

🔍 Search

</button>

<a
href="view_posts.php"
class="btn btn-secondary">

Reset

</a>

</div>

</form>

</div>

<?php

if($result->num_rows > 0){

while($row = $result->fetch_assoc()){

?>

<div class="card shadow mb-4">

<div class="card-body">

<h3 class="text-primary">

<?php echo htmlspecialchars($row['title']); ?>

</h3>

<p>

<?php echo nl2br(htmlspecialchars($row['content'])); ?>

</p>

<p class="text-muted">

📅 Posted on:

<?php echo htmlspecialchars($row['created_at']); ?>

</p>

<a
href="edit_post.php?id=<?php echo $row['id'];?>"
class="btn btn-warning">

✏ Edit

</a>

<?php if($_SESSION['role']=="admin"){ ?>

<a
href="delete_post.php?id=<?php echo $row['id'];?>"
class="btn btn-danger"
onclick="return confirm('Delete this post?')">

🗑 Delete

</a>

<?php } ?>

</div>

</div>

<?php

}

}else{

?>

<div class="alert alert-info">

📭 No posts found.

</div>

<?php

}

?>

<nav>

<ul class="pagination justify-content-center">

<?php

for($i=1;$i<=$totalPages;$i++){

?>

<li class="page-item <?php if($page==$i) echo 'active'; ?>">

<a
class="page-link"
href="?page=<?php echo $i; ?>&search=<?php echo urlencode($search); ?>">

<?php echo $i; ?>

</a>

</li>

<?php

}

?>

</ul>

</nav>

<a
href="dashboard.php"
class="btn btn-secondary">

⬅ Back to Dashboard

</a>

</div>

<?php

$stmt->close();

include "includes/footer.php";

?>