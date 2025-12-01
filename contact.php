
<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);




include __DIR__ . '/includes/header.php';
include __DIR__ . '/includes/db_connect.php';

$name = $email = $message = "";
$success = $error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $message = trim($_POST["message"]);

    if ($name && $email && $message) {
        $stmt = $conn->prepare("INSERT INTO messages (name, email, message) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $email, $message);
        if ($stmt->execute()) {
            $success = "✅ Your message was sent successfully!";
            $name = $email = $message = "";
        } else {
            $error = "❌ Could not send your message: " . $stmt->error;
        }
        $stmt->close();
    } else {
        $error = "⚠️ Please fill in all fields.";
    }
}
?>

<section class="page-header">
  <h1>Contact Us</h1>
  <p>We’d love to hear from you!</p>
</section>

<section class="contact-form-section">
  <?php if ($success) echo "<p style='color:green;'>$success</p>"; ?>
  <?php if ($error) echo "<p style='color:red;'>$error</p>"; ?>

  <form method="POST" class="contact-form">
    <label for="name">Name</label>
    <input type="text" name="name" value="<?= htmlspecialchars($name) ?>" required>

    <label for="email">Email</label>
    <input type="email" name="email" value="<?= htmlspecialchars($email) ?>" required>

    <label for="message">Message</label>
    <textarea name="message" rows="5" required><?= htmlspecialchars($message) ?></textarea>

    <button type="submit" class="btn">Send Message</button>
  </form>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
