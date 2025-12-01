<?php
session_start();
include '../includes/db_connect.php';
include 'admin_navbar.php';

// Check if the admin is logged in
if (!isset($_SESSION['admin_username'])) {
    header("Location: admin_login.php");
    exit;
}

// Fetch some quick stats
$totalTours = $conn->query("SELECT COUNT(*) AS count FROM tours")->fetch_assoc()['count'] ?? 0;
$totalMessages = $conn->query("SELECT COUNT(*) AS count FROM messages")->fetch_assoc()['count'] ?? 0;
$totalBlogPosts = $conn->query("SELECT COUNT(*) AS count FROM posts")->fetch_assoc()['count'] ?? 0;
$totalUsers = $conn->query("SELECT COUNT(*) AS count FROM users")->fetch_assoc()['count'] ?? 0;
?>

<link rel="stylesheet" href="../css/admin.css">

<div class="admin-container">
    <h1>Welcome, <?php echo htmlspecialchars($_SESSION['admin_username']); ?> 👋</h1>
    <p>Here’s an overview of your site’s activity:</p>

    <div class="admin-stats">
        <div class="stat-card">
            <h2><?php echo $totalTours; ?></h2>
            <p>Tours Available</p>
        </div>
        <div class="stat-card">
            <h2><?php echo $totalBlogPosts; ?></h2>
            <p>Blog Posts</p>
        </div>
        <div class="stat-card">
            <h2><?php echo $totalMessages; ?></h2>
            <p>Messages Received</p>
        </div>
        <div class="stat-card">
            <h2><?php echo $totalUsers; ?></h2>
            <p>Registered Users</p>
        </div>
    </div>

    <hr>

    <div class="admin-links">
        <h2>Quick Actions</h2>
        <a href="manage_posts.php" class="btn">📝 Manage Blog</a>
        <a href="add_blog.php" class="btn">➕ Add Blog Post</a>
        <a href="admin_messages.php" class="btn">📬 View Messages</a>
        <a href="setup_tours.php" class="btn">🌴 Manage Tours</a>
        <a href="logout.php" class="btn-cancel">🚪 Logout</a>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
