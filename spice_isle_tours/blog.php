<?php
include __DIR__ . '/includes/header.php';
include __DIR__ . '/includes/db_connect.php';
?>

<!-- Hero Section -->
<section class="hero">
    <h1>Our Blog</h1>
    <p>Stay updated with travel tips, news, and stories from the Spice Isle</p>
</section>

<!-- Page Header -->
<section class="page-header">
    <h2>Latest Posts</h2>
    <p>Discover tips, travel guides, and insider stories to make your trips unforgettable!</p>
</section>

<!-- Main Blog Section -->
<section class="blog-section">
    <div class="blog-list">
        <div class="blog-cards">
            <?php
            $sql = "SELECT * FROM blog_posts ORDER BY created_at DESC";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="blog-card">';
                    echo '<img src="images/' . htmlspecialchars($row['image']) . '" alt="' . htmlspecialchars($row['title']) . '" class="blog-img">';
                    echo '<div class="blog-content">';
                    echo '<h3>' . htmlspecialchars($row['title']) . '</h3>';
                    echo '<p>' . substr(htmlspecialchars($row['content']), 0, 120) . '...</p>';
                    echo '<a href="blog_post.php?id=' . $row['id'] . '" class="btn">Read More</a>';
                    echo '</div>';
                    echo '</div>';
                }
            } else {
                echo '<p>No blog posts available yet. Check back soon for exciting travel stories!</p>';
            }
            ?>
        </div>

        <!-- Sidebar: Popular Posts -->
        <aside class="blog-sidebar">
            <h3>Popular Posts</h3>
            <ul>
                <?php
                $popularSql = "SELECT * FROM blog_posts ORDER BY created_at DESC LIMIT 5";
                $popularResult = $conn->query($popularSql);

                if ($popularResult->num_rows > 0) {
                    while ($post = $popularResult->fetch_assoc()) {
                        echo '<li><a href="blog_post.php?id=' . $post['id'] . '">' . htmlspecialchars($post['title']) . '</a></li>';
                    }
                }
                ?>
            </ul>
        </aside>
    </div>
</section>

<!-- Newsletter Section -->
<section class="newsletter-cta">
    <h2>Subscribe to Our Newsletter</h2>
    <p>Get the latest travel tips, tour updates, and special offers delivered straight to your inbox!</p>
    <form action="subscribe.php" method="post" class="newsletter-form">
        <input type="email" name="email" class="newsletter-input" placeholder="Enter your email" required>
        <button type="submit" class="btn">Subscribe</button>
    </form>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
