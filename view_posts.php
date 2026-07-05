<?php
session_start();
include "config/database.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$search = "";

if(isset($_GET['search'])){
    $search = mysqli_real_escape_string($conn,$_GET['search']);
}

$limit = 5;

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

$start = ($page-1)*$limit;

$countQuery = "SELECT COUNT(*) AS total
FROM posts
WHERE title LIKE '%$search%'
OR content LIKE '%$search%'";

$countResult = mysqli_query($conn,$countQuery);

$totalPosts = mysqli_fetch_assoc($countResult)['total'];

$totalPages = ceil($totalPosts/$limit);

$sql = "SELECT *
FROM posts
WHERE title LIKE '%$search%'
OR content LIKE '%$search%'
ORDER BY created_at DESC
LIMIT $start,$limit";

$result = mysqli_query($conn,$sql);

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
value="<?php echo htmlspecialchars($search); ?>">

<button class="btn btn-primary">

🔍 Search

</button>

</div>

</form>

</div>

<?php

if(mysqli_num_rows($result)>0){

while($row=mysqli_fetch_assoc($result)){

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

<?php echo $row['created_at']; ?>

</p>

<a
href="edit_post.php?id=<?php echo $row['id'];?>"
class="btn btn-warning">

✏ Edit

</a>

<a
href="delete_post.php?id=<?php echo $row['id'];?>"
class="btn btn-danger"
onclick="return confirm('Delete this post?')">

🗑 Delete

</a>

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

<li class="page-item <?php if($page==$i) echo 'active';?>">

<a
class="page-link"
href="?page=<?php echo $i;?>&search=<?php echo urlencode($search);?>">

<?php echo $i;?>

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

<?php include "includes/footer.php"; ?>