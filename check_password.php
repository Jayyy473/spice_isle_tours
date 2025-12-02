<?php
include __DIR__ . '/includes/db_connect.php';

$username = 'admin';
$passwordPlain = 'Admin123!';

$stmt = $conn->prepare("SELECT password FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->bind_result($hashFromDB);
$stmt->fetch();

if ($hashFromDB) {
    if (password_verify($passwordPlain, $hashFromDB)) {
        echo "✅ Password matches!";
    } else {
        echo "❌ Password does NOT match!";
    }
} else {
    echo "❌ Username not found!";
}

$stmt->close();
$conn->close();
?>
