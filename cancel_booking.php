<?php
session_start();
include __DIR__ . '/includes/db_connect.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}
if (isset($_GET['msg'])) {
    echo '<p style="color:green; font-weight:bold;">' . htmlspecialchars($_GET['msg']) . '</p>';
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['booking_id'])) {
    $booking_id = intval($_POST['booking_id']);

    // Get user ID
    $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
    $stmt->bind_param("s", $_SESSION['username']);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $user_id = $user['id'];
    } else {
        die("❌ User not found.");
    }
    $stmt->close();

    // Delete the booking
    $stmt = $conn->prepare("DELETE FROM bookings WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ii", $booking_id, $user_id);

    if ($stmt->execute()) {
        $message = "✅ Booking canceled successfully!";
    } else {
        $message = "❌ Failed to cancel booking: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();

    // Redirect back with a message
    header("Location: my_bookings.php?msg=" . urlencode($message));
    exit;
} else {
    header("Location: my_bookings.php");
    exit;
}
?>
