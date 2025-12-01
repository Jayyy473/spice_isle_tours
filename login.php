<?php
session_start();
include __DIR__ . '/includes/db_connect.php';


$error = "";

// If already logged in
if (isset($_SESSION['username'])) {
    echo "You are already logged in as " . $_SESSION['username'] . ". <a href='logout.php'>Logout</a>";
    exit;
}

// Handle login form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $user = $result->fetch_assoc();

        if (password_verify($password, $user['password'])) {
            $_SESSION['username'] = $user['username'];
            header("Location: index.php");
            exit;
        } else {
            $error = "❌ Invalid password.";
        }
    } else {
        $error = "⚠️ User not found.";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Login - Spice Isle Tours</title>

</head>
<body>
<h2>Login</h2>
<form action="" method="post">
    <label>Username: <input type="text" name="username" required></label><br><br>
    <label>Password: <input type="password" name="password" required></label><br><br>
    <button type="submit">Login</button>
</form>
<p style="color:red;"><?= $error ?></p>
<p>Don't have an account? <a href="register.php">Register here</a></p>
</body>
</html>
