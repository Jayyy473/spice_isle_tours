<?php
session_start();
include('admin_navbar.php'); // navbar from admin folder
include('../includes/db_connect.php'); // DB connection



if (!isset($_SESSION['admin_username'])) {
    header("Location: admin_login.php");
    exit;
}

// Messages
$msg = "";

// ADD POST
if (isset($_POST['add_post'])) {
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);

    // Check duplicates
    $stmt = $conn->prepare("SELECT COUNT(*) as count FROM blog_posts WHERE title=?");
    $stmt->bind_param("s", $title);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if ($row['count'] > 0) {
        $msg = "A post with this title already exists!";
    } else {
        $stmt = $conn->prepare("INSERT INTO blog_posts (title, content) VALUES (?, ?)");
        $stmt->bind_param("ss", $title, $content);
        $stmt->execute();
        $msg = "New post added successfully!";
    }
}

// DELETE POST
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $stmt = $conn->prepare("DELETE FROM blog_posts WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $msg = "Post deleted successfully!";
}

// FETCH POSTS
$posts = $conn->query("SELECT * FROM blog_posts ORDER BY id DESC");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Blog Management</title>
    <link rel="stylesheet" href="../css/admin.css">

</head>
<body>
<?php include 'admin_navbar.php'; ?>

<h1>Manage Blog Posts</h1>

<?php if ($msg) echo "<p style='color:green;'>$msg</p>"; ?>

<!-- ADD NEW POST -->
<h2>Add New Post</h2>
<form method="post">
    <label

    <?php include('../includes/footer.php'); ?>