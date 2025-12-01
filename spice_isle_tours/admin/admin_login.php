<?php
session_start();
include '../includes/db_connect.php'; // Adjust path if needed

// If admin is already logged in, redirect to dashboard
if (isset($_SESSION['admin_username'])) {
    header("Location: dashboard.php");
    exit;
}

// Check login form submission
if (isset($_POST['username'], $_POST['password'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $sql = "SELECT * FROM admins WHERE username=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        if (password_verify($password, $row['password'])) {
            // Login successful
            $_SESSION['admin_username'] = $username;
            header("Location: dashboard.php");
            exit;
        } else {
            $error = "Incorrect password!";
        }
    } else {
        $error = "Admin not found!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login - Spice Isle Tours</title>
    <link rel="stylesheet" href="../css/admin.css">

</head>
<body>
    <div class="login-container">
        <h2>Admin Login</h2>
        <?php if(isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
        <form action="" method="POST">
            <label>Username</label>
            <input type="text" name="username" required>
            <label>Password</label>
            <input type="password" name="password" required>
            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>
