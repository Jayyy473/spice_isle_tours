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


// Handle form submission
if (isset($_POST['submit'])) {
    $title = $_POST['title'];
    $content = $_POST['content'];

    $sql = "INSERT INTO blog_posts (title, content) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $title, $content);

    if ($stmt->execute()) {
        echo "<p style='color:green;'>Blog post added successfully!</p>";
    } else {
        echo "<p style='color:red;'>Error: " . $conn->error . "</p>";
    }
}
?>

<h2>Add New Blog Post</h2>
<form method="post">
    <label>Title:</label><br>
    <input type="text" name="title" required><br><br>

    <label>Content:</label><br>
    <textarea name="content" rows="10" cols="50" required></textarea><br><br>

    <button type="submit" name="submit">Add Post</button>
</form>

<?php include('../includes/footer.php'); ?>