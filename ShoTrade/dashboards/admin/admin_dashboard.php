<?php
session_start();
require_once '../../includes/db.php';

// Protect admin access
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}

// Get totals
$userCount = $conn->query("SELECT COUNT(*) AS total FROM users")->fetch_assoc()['total'];
$listingCount = $conn->query("SELECT COUNT(*) AS total FROM listings")->fetch_assoc()['total'];
$reportCount = $conn->query("SELECT COUNT(*) AS total FROM reports")->fetch_assoc()['total'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Panel</title>
  <style>
    body {
      margin: 0;
      font-family: Arial, sans-serif;
      display: flex;
      background: #f4f4f9;
    }

    /* Sidebar */
    .sidebar {
      width: 220px;
      background: #222;
      color: #fff;
      height: 100vh;
      padding-top: 20px;
      position: fixed;
      top: 0;
      left: 0;
    }

    .sidebar h2 {
      text-align: center;
      margin-bottom: 30px;
      font-size: 22px;
      color: #fff;
    }

    .sidebar a {
      display: block;
      padding: 15px 20px;
      color: #fff;
      text-decoration: none;
      border-bottom: 1px solid #333;
      transition: 0.3s;
    }

    .sidebar a:hover {
      background: #444;
    }

    /* Main Content */
    .main-content {
      margin-left: 220px;
      padding: 20px;
      width: calc(100% - 220px);
      min-height: 100vh;
    }

    .main-content h1 {
      margin-top: 0;
      color: #333;
    }

    /* Tiles */
    .tile-container {
      display: flex;
      gap: 20px;
      margin-top: 20px;
      flex-wrap: wrap;
    }

    .tile {
      flex: 1;
      min-width: 250px;
      background: #fff;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
      text-align: center;
      transition: transform 0.2s ease;
    }

    .tile:hover {
      transform: translateY(-5px);
    }

    .tile h2 {
      margin: 0 0 10px;
      color: #555;
    }

    .tile span {
      font-size: 28px;
      font-weight: bold;
      color: #222;
    }

    /* Colors for tiles */
    .tile.users { border-top: 5px solid #3498db; }
    .tile.listings { border-top: 5px solid #2ecc71; }
    .tile.reports { border-top: 5px solid #e74c3c; }

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

  <div class="main-content">
    <h1>Welcome, Admin</h1>
    <div class="tile-container">
        <div class="tile users">
            <h2>Total Users</h2>
            <span><?= $userCount ?></span>
        </div>
        <div class="tile listings">
            <h2>Total Listings</h2>
            <span><?= $listingCount ?></span>
        </div>
        <div class="tile reports">
            <h2>Total Reports</h2>
            <span><?= $reportCount ?></span>
        </div>
    </div>
  </div>

</body>
</html>
