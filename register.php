<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include __DIR__ . '/includes/db_connect.php';
include __DIR__ . '/includes/header.php'; 


$error = "";
$success = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password'] ?? '');

    if (!$username || !$email || !$password || !$confirm_password) {
        $error = "⚠️ All fields are required!";
    } elseif ($password !== $confirm_password) {
        $error = "⚠️ Passwords do not match!";
    } else {
        // Check if username/email exists
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
        $stmt->bind_param("ss", $username, $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows > 0) {
            $error = "⚠️ Username or email already exists!";
        } else {
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $username, $email, $passwordHash);

            if ($stmt->execute()) {
                $_SESSION['username'] = $username;
                $success = "✅ Registration successful! Redirecting to login...";
                header("Refresh:3; url=login.php");
            } else {
                $error = "❌ Error: " . $stmt->error;
            }
            $stmt->close();
        }
        $stmt->close();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Register - Spice Isle Tours</title>
<link rel="stylesheet" href="css/style.css">
<style>
.register-container { max-width: 400px; margin: 50px auto; padding: 20px; border: 1px solid #ccc; border-radius: 8px; }
label { display: block; margin-top: 10px; }
input { width: 100%; padding: 8px; margin-top: 5px; }
button { margin-top: 15px; padding: 10px 20px; cursor: pointer; }
.error { color: #c00; margin-top: 10px; }
.success { color: #080; margin-top: 10px; }
a { color: #0066cc; text-decoration: none; }
a:hover { text-decoration: underline; }
</style>
</head>
<body>
<div class="register-container">
<h2>Register</h2>
<?php
if (!empty($error)) echo '<p class="error">'.$error.'</p>';
if (!empty($success)) echo '<p class="success">'.$success.'</p>';
?>
<form action="" method="POST">
    <label>Username:</label>
    <input type="text" name="username" required>
    <label>Email:</label>
    <input type="email" name="email" required>
    <label>Password:</label>
    <input type="password" name="password" required>
    <label>Confirm Password:</label>
    <input type="password" name="confirm_password" required>
    <button type="submit">Register</button>
</form>
<p>Already have an account? <a href="login.php">Login here</a></p>
</div>
</body>
</html>
