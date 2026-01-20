<?php include('header_user.php'); ?>
<?php include('sidebar_user.php'); ?>
<?php
require_once '../../includes/db.php';

$userId = $_SESSION['user_id'];

$stmt = $conn->prepare("SELECT dr.status, dr.created_at, l.title, l.image, d.name AS driver_name
                        FROM delivery_requests dr
                        JOIN listings l ON dr.listing_id = l.id
                        LEFT JOIN users d ON dr.driver_id = d.id
                        WHERE dr.user_id = ?
                        ORDER BY dr.created_at DESC");
$stmt->bind_param("i", $userId);
$stmt->execute();
$orders = $stmt->get_result();
?>

<h2 style= "font-weight: bold; font-size: 30px; padding-left:10px;">My Orders</h2>
<?php while ($row = $orders->fetch_assoc()): ?>
  <div style="border:1px solid #ccc; margin:10px; padding:10px; border-radius:8px;">
    <strong>Item:</strong> <?= htmlspecialchars($row['title']) ?><br>
    <strong>Status:</strong> <?= ucfirst($row['status']) ?><br>
    <?php if ($row['driver_name']): ?>
      <strong>Driver:</strong> <?= htmlspecialchars($row['driver_name']) ?><br>
    <?php endif; ?>
    <strong>Requested On:</strong> <?= date('Y-m-d H:i', strtotime($row['created_at'])) ?><br>
    <?php if ($row['image']): ?>
      <img src="../../uploads/<?= $row['image'] ?>" style="width:100px; height:auto;">
    <?php endif; ?>
  </div>
<?php endwhile; ?>

<?php include('nav_user.php'); ?>
