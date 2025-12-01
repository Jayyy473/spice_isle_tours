<?php
session_start();
include __DIR__ . '/includes/db_connect.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

// Get logged-in user ID
$username = $_SESSION['username'];
$stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$user_id = $user['id'];

// Get tour ID from POST
if (!isset($_POST['tour_id'])) {
    die("❌ No tour selected.");
}
$tour_id = $_POST['tour_id'];

// Check if user already booked this tour
$stmt = $conn->prepare("SELECT * FROM bookings WHERE user_id = ? AND tour_id = ?");
$stmt->bind_param("ii", $user_id, $tour_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    die("⚠️ You have already booked this tour.");
}

// Insert booking
$stmt = $conn->prepare("INSERT INTO bookings (user_id, tour_id) VALUES (?, ?)");
$stmt->bind_param("ii", $user_id, $tour_id);

if ($stmt->execute()) {
    echo "<h2>Booking Status</h2>";
    echo "✅ Tour booked successfully!";
    echo '<br><a href="tours.php">Back to Tours</a>';
} else {
    echo "❌ Booking failed: " . $stmt->error;
}

$stmt->close();
$conn->close();
