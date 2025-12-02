

<?php
// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


// admin/dashboard.php
session_start();
include('admin_navbar.php'); // navbar from admin folder
include('../includes/db_connect.php'); // DB connection




?>

<section class="page-header">
  <h1>📬 Messages Inbox</h1>
  <p>Here are the messages submitted through the contact form.</p>
</section>

<section class="messages-section">
  <table class="messages-table">
    <thead><link rel="stylesheet" href="../css/admin.css">

      <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Message</th>
        <th>Date</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $sql = "SELECT * FROM messages ORDER BY created_at DESC";
      $result = $conn->query($sql);

      if ($result && $result->num_rows > 0) {
          while ($msg = $result->fetch_assoc()) {
              echo "<tr>";
              echo "<td>" . htmlspecialchars($msg['id']) . "</td>";
              echo "<td>" . htmlspecialchars($msg['name']) . "</td>";
              echo "<td>" . htmlspecialchars($msg['email']) . "</td>";
              echo "<td>" . htmlspecialchars($msg['message']) . "</td>";
              echo "<td>" . htmlspecialchars($msg['created_at']) . "</td>";
              echo "</tr>";
          }
      } else {
          echo "<tr><td colspan='5' style='text-align:center;'>No messages found.</td></tr>";
      }

      $conn->close();
      ?>
    </tbody>
  </table>
</section>

<?php include('../includes/footer.php'); ?>