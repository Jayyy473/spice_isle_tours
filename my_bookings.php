

<?php
session_start();
include __DIR__ . '/includes/db_connect.php';
include __DIR__ . '/includes/header.php';


// Check login
if (!isset($_SESSION['username'])) {
    echo "<p>⚠️ You must be logged in to view your bookings. <a href='login.php'>Login here</a></p>";
    exit;
}

// Logged-in username
$username = $_SESSION['username'];

// Get user ID from database
$stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
if (!$stmt) {
    die("❌ Prepare failed: " . $conn->error);
}
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows === 0) {
    die("⚠️ User not found in database.");
}
$user = $result->fetch_assoc();
$user_id = $user['id'];

// Fetch bookings
$stmt = $conn->prepare("
    SELECT b.id AS booking_id, t.title, t.description, t.price, t.image, b.booking_date
    FROM bookings b
    JOIN tours t ON b.tour_id = t.id
    WHERE b.user_id = ?
    ORDER BY b.booking_date DESC
");
if (!$stmt) {
    die("❌ Prepare failed: " . $conn->error);
}
$stmt->bind_param("i", $user_id);
$stmt->execute();
$bookings = $stmt->get_result();
if (!$bookings) {
    die("❌ Query failed: " . $conn->error);
}
?>

<section class="page-header">
    <h1>My Bookings</h1>
    <p>Here are all the tours you’ve booked, <?php echo htmlspecialchars($username); ?>.</p>
</section>

<section class="tour-list">
    <div class="tour-cards">
        <?php
        if ($bookings->num_rows > 0) {
            while ($booking = $bookings->fetch_assoc()) {
                echo '<div class="tour-card">';
                echo '<img src="images/' . $booking['image'] . '" alt="' . $booking['title'] . '">';
                echo '<h3>' . $booking['title'] . '</h3>';
                echo '<p>' . $booking['description'] . '</p>';
                echo '<p><strong>Price: $' . $booking['price'] . '</strong></p>';
                echo '<p><em>Booked on: ' . $booking['booking_date'] . '</em></p>';
                echo '<form method="POST" action="cancel_booking.php" style="margin-top:10px;">';
                echo '<input type="hidden" name="booking_id" value="' . $booking['booking_id'] . '">';
                echo '<button type="submit" class="btn">Cancel Booking</button>';
                echo '</form>';
                echo '</div>';
            }
        } else {
            echo '<p>You have no bookings yet. Browse our <a href="tours.php">tours</a> and book your adventure!</p>';
        }
        ?>
    </div>
</section>

<?php
$stmt->close();
$conn->close();
include 'includes/footer.php';
?>
