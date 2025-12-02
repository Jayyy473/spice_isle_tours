<?php
session_start();
include '../includes/db_connect.php';
include 'admin_navbar.php';

// Handle Add New Tour
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_tour'])) {
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $price = trim($_POST['price']);
    $image = trim($_POST['image']);

    if ($title && $description && $price && $image) {
        $stmt = $conn->prepare("INSERT INTO tours (title, description, price, image) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssds", $title, $description, $price, $image);
        if ($stmt->execute()) {
            $message = "✅ New tour added successfully!";
        } else {
            $message = "❌ Error adding tour: " . $conn->error;
        }
        $stmt->close();
    } else {
        $message = "⚠️ Please fill out all fields.";
    }
}

// Handle Delete
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM tours WHERE id=$id");
    $message = "🗑️ Tour deleted successfully!";
}

// Fetch all tours
$result = $conn->query("SELECT * FROM tours ORDER BY created_at DESC");
?>

<link rel="stylesheet" href="../css/admin.css">

<div class="admin-container">
    <h1>Manage Tours</h1>
    <?php if (!empty($message)): ?>
        <p class="admin-message"><?php echo $message; ?></p>
    <?php endif; ?>

    <!-- Add New Tour Form -->
    <form method="POST" class="admin-form">
        <h2>Add a New Tour</h2>
        <label>Title:</label>
        <input type="text" name="title" required>

        <label>Description:</label>
        <textarea name="description" rows="3" required></textarea>

        <label>Price (USD):</label>
        <input type="number" step="0.01" name="price" required>

        <label>Image Filename (e.g., beach1.jpeg):</label>
        <input type="text" name="image" required>

        <button type="submit" name="add_tour" class="btn">Add Tour</button>
    </form>

    <hr>

    <!-- Display All Tours -->
    <h2>All Tours</h2>
    <table class="admin-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Description</th>
                <th>Price ($)</th>
                <th>Image</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($tour = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $tour['id']; ?></td>
                    <td><?php echo htmlspecialchars($tour['title']); ?></td>
                    <td><?php echo htmlspecialchars(substr($tour['description'], 0, 60)); ?>...</td>
                    <td><?php echo number_format($tour['price'], 2); ?></td>
                    <td><img src="../images/<?php echo $tour['image']; ?>" alt="" width="80"></td>
                    <td><a href="?delete=<?php echo $tour['id']; ?>" class="btn-cancel" onclick="return confirm('Delete this tour?');">Delete</a></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<?php include '../includes/footer.php'; ?>
