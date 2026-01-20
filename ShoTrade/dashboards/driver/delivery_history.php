
<?php include('header_driver.php'); ?>
<?php include('sidebar_driver.php'); ?>
<?php
require_once '../../includes/db.php';


$driverId = $_SESSION['user_id'];

$stmt = $conn->prepare("SELECT dr.id, l.title, u.name, u.address, dr.status, dr.created_at
                        FROM delivery_requests dr
                        JOIN listings l ON dr.listing_id = l.id
                        JOIN users u ON dr.user_id = u.id
                        WHERE dr.driver_id = ? AND dr.status = 'delivered'
                        ORDER BY dr.created_at DESC");
$stmt->bind_param("i", $driverId);
$stmt->execute();
$history = $stmt->get_result();
?>

<h2 style= "font-weight: bold; font-size: 30px; padding-left:10px;">Delivery History</h2>
<?php while ($row = $history->fetch_assoc()): ?>
  <div style="border:1px solid #ccc; margin:10px; padding:10px; border-radius:8px; background:#f1f1f1;">
    <strong>Listing:</strong> <?= htmlspecialchars($row['title']) ?><br>
    <strong>Delivered To:</strong> <?= htmlspecialchars($row['name']) ?> (<?= htmlspecialchars($row['address']) ?>)<br>
    <strong>Delivered On:</strong> <?= date('Y-m-d H:i', strtotime($row['created_at'])) ?>
  </div>
<?php endwhile; ?>

<?php include('nav_driver.php'); ?>
