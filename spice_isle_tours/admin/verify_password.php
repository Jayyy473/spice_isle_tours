<?php
$plaintextPassword = 'Admin123!'; // the password you want to test
$hashFromDB = '$2y$10$EXACTHASHFROMDB'; // copy EXACTLY from DB

if (password_verify($plaintextPassword, $hashFromDB)) {
    echo "✅ Password matches!";
} else {
    echo "❌ Password does NOT match!";
}
?>
