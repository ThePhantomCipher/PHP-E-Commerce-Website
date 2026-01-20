<?php
require_once '../../includes/db.php';
session_start();

$listings = $conn->query("SELECT * FROM listings");
?>

<!DOCTYPE html>
<html>
<head>
  <title>Manage Listings</title>
  <style>
    body { margin: 0; font-family: Arial, sans-serif; display: flex; background: #f4f4f4; }
    .sidebar { width: 220px; background: #333; color: #fff; height: 100vh; position: fixed; padding-top: 20px; }
    .sidebar h2 { text-align: center; margin-bottom: 30px; font-size: 22px; color: #fff; }
    .sidebar a { display: block; padding: 15px 20px; color: #fff; text-decoration: none; border-bottom: 1px solid #444; }
    .sidebar a:hover { background: #444; }

    .main { margin-left: 220px; padding: 30px; width: 100%; }
    table { width: 100%; border-collapse: collapse; background: #fff; }
    th, td { padding: 12px 15px; border-bottom: 1px solid #ddd; text-align: left; }
    th { background: #333; color: white; }
    tr:hover { background-color: #f1f1f1; }
    h1 { margin-top: 0; }
  </style>
</head>
<body>

  <div class="sidebar">
    <h2>Admin Panel</h2>
    <a href="admin_dashboard.php">Dashboard</a>
    <a href="manage_users.php">Manage Users</a>
    <a href="manage_listings.php">Manage Listings</a>
    <a href="messages.php">Messages</a>
    <a href="admin_reports.php">Reports</a>
    <a href="../../logout.php">Logout</a>
  </div>

  <div class="main">
    <h1>Manage Listings</h1>
    <table>
      <tr>
        <th>ID</th><th>Title</th><th>Description</th><th>Price</th><th>Actions</th>
      </tr>
      <?php while ($listing = $listings->fetch_assoc()): ?>
        <tr>
          <td><?= $listing['id'] ?></td>
          <td><?= $listing['title'] ?></td>
          <td><?= $listing['description'] ?></td>
          <td>R<?= $listing['price'] ?></td>
          <td>
            <a href="view_listing.php?id=<?= $listing['id'] ?>">View</a> |
            <a href="delete_listing.php?id=<?= $listing['id'] ?>" onclick="return confirm('Delete listing?')">Delete</a>
          </td>
        </tr>
      <?php endwhile; ?>
    </table>
  </div>

</body>
</html>

