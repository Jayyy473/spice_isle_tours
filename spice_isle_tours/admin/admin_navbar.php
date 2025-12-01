<?php
if (!isset($_SESSION)) session_start();
?>

<!-- Link to admin stylesheet -->
<link rel="stylesheet" href="../css/admin.css">

<!-- Admin Navbar -->
<nav class="admin-navbar">
    <h2>Admin Panel</h2>
    <ul>
        <li><a href="dashboard.php">Dashboard</a></li>
        <li><a href="manage_posts.php">Manage Blog</a></li>
        <li><a href="add_blog.php">Add Blog Post</a></li>
        <li><a href="admin_messages.php">Messages</a></li>
        <li><a href="setup_tours.php">Tours</a></li>
        <li><a href="logout.php">Logout (<?php echo htmlspecialchars($_SESSION['admin_username']); ?>)</a></li>
    </ul>
</nav>
<hr>
