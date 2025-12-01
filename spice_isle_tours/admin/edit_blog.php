<?php
session_start();
include('admin_navbar.php'); // navbar from admin folder
include('../includes/db_connect.php'); // DB connection
?>




<?php
session_start();
if (!isset($_SESSION['admin_username'])) {
    header("Location: admin_login.php");
    exit;
}



if (!isset($_GET['id'])) {
    echo "No post selected!";
    exit;
}

$id = $_GET['id'];

// Fetch current post
$sql = "SELECT * FROM blog_posts WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$post = $result->fetch_assoc();

if (!$post) {
    echo "Post not found!";
    exit;
}

// Handle form submission
if (isset($_POST['submit'])) {
    $title = $_POST['title'];
    $content = $_POST['content'];

    $sql = "UPDATE blog_posts SET title=?, content=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $title, $content, $id);
    $stmt->execute();

    echo "<p style='color:green;'>Post updated successfully!</p>";
}
?>

<h2>Edit Blog Post</h2>
<form method="post">
    <label>Title:</label><br>
    <input type="text" name="title" value="<?= htmlspecialchars($post['title']) ?>" required><br><br>

    <label>Content:</label><br>
    <textarea name="content" rows="10" cols="50" required><?= htmlspecialchars($post['content']) ?></textarea><br><br>

    <button type="submit" name="submit">Update Post</button>
</form>

<?php include('../includes/footer.php'); ?>