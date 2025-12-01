<?php
session_start();
include('admin_navbar.php'); // navbar from admin folder
include('../includes/db_connect.php'); // DB connection
?>


<?php
session_start();
if (!isset($_SESSION['admin_username'])) {
    header("Location: admin_login.php");
    exit;
}

?>

<section class="admin-dashboard">
    <h1>🗺️ Manage Tours</h1>
    <p>Here you can view, edit, or delete tours listed on the site.</p>

    <a href="setup_tours.php" class="btn">➕ Add New Tour</a>

    <div class="tours-table">
        <table border="1" cellpadding="10" cellspacing="0">
            <tr style="background-color:#009688; color:white;">
                <th>ID</th>
                <th>Title</th>
                <th>Description</th>
                <th>Price ($)</th>
                <th>Image</th>
                <th>Actions</th>
            </tr>

            <?php
            $sql = "SELECT * FROM tours ORDER BY id DESC";
            $result = $conn->query($sql);

            if ($result && $result->num_rows > 0) {
                while ($tour = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $tour['id'] . "</td>";
                    echo "<td>" . htmlspecialchars($tour['title']) . "</td>";
                    echo "<td>" . htmlspecialchars(substr($tour['description'], 0, 80)) . "...</td>";
                    echo "<td>$" . number_format($tour['price'], 2) . "</td>";
                    echo "<td><img src='../images/" . htmlspecialchars($tour['image']) . "' width='100' height='70'></td>";
                    echo "<td>
                            <a href='edit_tour.php?id=" . $tour['id'] . "' class='btn'>✏️ Edit</a>
                            <a href='delete_tour.php?id=" . $tour['id'] . "' class='btn-cancel' onclick='return confirm(\"Are you sure you want to delete this tour?\");'>🗑️ Delete</a>
                          </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6'>No tours found.</td></tr>";
            }
            ?>
        </table>
    </div>
</section>

<?php include('../includes/footer.php'); ?>

<style>
.admin-dashboard {
    max-width: 1000px;
    margin: 40px auto;
    padding: 20px;
    background: #fff;
    border-radius: 10px;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
}

.admin-dashboard h1 {
    color: #009688;
    margin-bottom: 10px;
}

.admin-dashboard .btn {
    background-color: #007bff;
    color: white;
    padding: 8px 15px;
    border-radius: 5px;
    text-decoration: none;
    margin-bottom: 15px;
    display: inline-block;
}

.admin-dashboard .btn:hover {
    background-color: #0056b3;
}

.tours-table table {
    width: 100%;
    border-collapse: collapse;
}

.tours-table img {
    border-radius: 5px;
    object-fit: cover;
}

.btn-cancel {
    background-color: #ff4d4d;
    color: #fff;
    padding: 8px 12px;
    border-radius: 5px;
    text-decoration: none;
}

.btn-cancel:hover {
    background-color: #cc0000;
}
</style>



<?php include('../includes/footer.php'); ?>