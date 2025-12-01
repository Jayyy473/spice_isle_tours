<?php
include __DIR__ . '/includes/db_connect.php';

// -----------------------------
// Step 1: Delete any existing admin entries
// -----------------------------
$stmt = $conn->prepare("DELETE FROM users WHERE username = ?");
$adminUsername = 'admin';
$stmt->bind_param("s", $adminUsername);
$stmt->execute();
$stmt->close();

// -----------------------------
// Step 2: Insert a fresh admin
// -----------------------------
$username = 'admin';
$email = 'admin@spiceisletours.com';
$passwordPlain = 'Admin123!'; // <-- This will be your login password

$passwordHash = password_hash($passwordPlain, PASSWORD_DEFAULT);

$stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $username, $email, $passwordHash);

if ($stmt->execute()) {
    echo "✅ Admin reset successfully!<br>";
    echo "Use username: <strong>$username</strong> and password: <strong>$passwordPlain</strong> to log in.";
} else {
    echo "❌ Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
