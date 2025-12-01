<?php
include __DIR__ . '/includes/header.php';
include __DIR__ . '/includes/db_connect.php';

?>

<section class="page-header">
    <h1>Our Tours</h1>
    <p>Choose your adventure and book today!</p>
</section>

<section class="tour-list">
    <div class="tour-cards">
        <?php
        $sql = "SELECT * FROM tours ORDER BY created_at DESC";
        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0) {
            while ($tour = $result->fetch_assoc()) {
                echo '<div class="tour-card">';
                echo '<img src="images/' . $tour['image'] . '" alt="' . $tour['title'] . '">';
                echo '<h3>' . $tour['title'] . '</h3>';
                echo '<p>' . $tour['description'] . '</p>';
                echo '<p><strong>Price: $' . $tour['price'] . '</strong></p>';
                echo '<a href="book.php?tour_id=' . $tour['id'] . '" class="btn">Book Now</a>';
                echo '</div>';
            }
        } else {
            echo '<p>No tours available at the moment. Please check back later.</p>';
        }
        ?>
    </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
