<?php
include '../includes/db_connect.php';

// Create admins table if it doesn't exist
$createTableSQL = "
CREATE TABLE IF NOT EXISTS admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
";

if ($conn->query($createTableSQL) === TRUE) {
    echo "✅ Admins table ready.<br>";
} else {
    die("❌ Error creating table: " . $conn->error);
}

// Add default admin user
$adminUsername = 'admin';
$adminPassword = password_hash('StrongPassword123', PASSWORD_DEFAULT);

// Check if admin already exists
$checkSQL = "SELECT * FROM admins WHERE username=?";
$stmt = $conn->prepare($checkSQL);
$stmt->bind_param("s", $adminUsername);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    // Insert new admin
    $insertSQL = "INSERT INTO admins (username, password) VALUES (?, ?)";
    $stmt = $conn->prepare($insertSQL);
    $stmt->bind_param("ss", $adminUsername, $adminPassword);
    if ($stmt->execute()) {
        echo "✅ Admin user created successfully!";
    } else {
        echo "❌ Error creating admin user: " . $stmt->error;
    }
} else {
    echo "ℹ️ Admin user already exists.";
}

$conn->close();
?>
