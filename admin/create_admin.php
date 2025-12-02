<?php
include __DIR__ . '/includes/db_connect.php';

// Set your admin credentials here
$username = 'admin';
$email = 'admin@spiceisletours.com';
$passwordPlain = 'Admin123!'; // <-- this is your login password

// Hash the password securely
$passwordHash = password_hash($passwordPlain, PASSWORD_DEFAULT);

// Insert into database
$stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $username, $email, $passwordHash);

if ($stmt->execute()) {
    echo "✅ Admin user created successfully!";
} else {
    echo "❌ Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
