<?php
session_start();
if (!isset($_SESSION['admin_username'])) {
    header("Location: admin_login.php");
    exit;
}

include 'admin_navbar.php';
include '../includes/db_connect.php';

// Handle deletion
if (isset($_GET['delete_id'])) {
    $id = $_GET['delete_id'];
    $sql = "DELETE FROM blog_posts WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    echo "<p style='color:red;'>Post deleted successfully!</p>";
}

// Fetch all blog posts
$sql = "SELECT * FROM blog_posts ORDER BY id DESC";
$result = $conn->query($sql);
?>

<h2>Manage Blog Posts</h2>

<table border="1" cellpadding="10">
    <tr>
        <th>ID</th>
        <th>Title</th>
        <th>Content</th>
        <th>Actions</th>
    </tr>

    <?php while ($row = $result->fetch_assoc()) : ?>
    <tr>
        <td><?= $row['id'] ?></td>
        <td><?= htmlspecialchars($row['title']) ?></td>
        <td><?= htmlspecialchars(substr($row['content'], 0, 100)) ?>...</td>
        <td>
            <a href="edit_blog.php?id=<?= $row['id'] ?>">Edit</a> |
            <a href="manage_posts.php?delete_id=<?= $row['id'] ?>" onclick="return confirm('Are you sure you want to delete this post?')">Delete</a>
        </td>
    </tr>
    <?php endwhile; ?>
</table>
