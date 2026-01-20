<?php
session_start();
require_once '../../includes/db.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
  header("Location: ../login.php");
  exit;
}

// Run aggregation queries
$totalUsers = $conn->query("SELECT COUNT(*) AS count FROM users")->fetch_assoc()['count'];
$totalDrivers = $conn->query("SELECT COUNT(*) AS count FROM users WHERE role = 'driver'")->fetch_assoc()['count'];
$totalListings = $conn->query("SELECT COUNT(*) AS count FROM listings")->fetch_assoc()['count'];
$totalOrders = $conn->query("SELECT COUNT(*) AS count FROM orders")->fetch_assoc()['count'];
$totalDeliveries = $conn->query("SELECT COUNT(*) AS count FROM deliveries")->fetch_assoc()['count'] ?? 0;
?>

<!DOCTYPE html>
<html>
<head>
  <title>Admin Reports</title>
  <style>
    body { font-family: Arial, sans-serif; background: #f4f4f4; display: flex; margin: 0; }
    .sidebar { width: 220px; background: #333; color: #fff; height: 100vh; position: fixed; padding-top: 20px; }
    .sidebar a { display: block; padding: 15px 20px; color: #fff; text-decoration: none; border-bottom: 1px solid #444; }
    .sidebar a:hover { background: #444; }
    .main { margin-left: 220px; padding: 40px; width: 100%; }
    h1 { margin-top: 0; }
    .card {
      background: white;
      border-radius: 10px;
      padding: 25px;
      margin-bottom: 20px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
      font-size: 18px;
    }
    .card span { font-weight: bold; font-size: 22px; color: #007acc; }
  </style>
</head>
<body>

  <div class="sidebar">
    <h2 style="text-align:center;">Admin</h2>
    <a href="admin_dashboard.php">Dashboard</a>
    <a href="manage_users.php">Manage Users</a>
    <a href="manage_listings.php">Manage Listings</a>
    <a href="messages.php">Messages</a>
    <a href="admin_reports.php">Reports</a>
    <a href="../logout.php">Logout</a>
  </div>

  <div class="main">
    <h1>System Reports</h1>

    <div class="card">Total Users: <span><?= $totalUsers ?></span></div>
    <div class="card">Total Drivers: <span><?= $totalDrivers ?></span></div>
    <div class="card">Total Listings: <span><?= $totalListings ?></span></div>
    <div class="card">Total Orders: <span><?= $totalOrders ?></span></div>
    <div class="card">Total Deliveries: <span><?= $totalDeliveries ?></span></div>
  </div>

</body>
</html>
