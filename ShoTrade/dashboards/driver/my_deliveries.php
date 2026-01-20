
<?php include('header_driver.php'); ?>
<?php include('sidebar_driver.php'); ?>
<?php
require_once '../../includes/db.php';

$driverId = $_SESSION['user_id'];

$stmt = $conn->prepare("SELECT dr.id, l.title, u.name, u.address 
                        FROM delivery_requests dr
                        JOIN listings l ON dr.listing_id = l.id
                        JOIN users u ON dr.user_id = u.id
                        WHERE dr.driver_id = ? AND dr.status = 'accepted'");
$stmt->bind_param("i", $driverId);
$stmt->execute();
$deliveries = $stmt->get_result();
?>

<h2 style= "font-weight: bold; font-size: 30px; padding-left:10px;">My Deliveries</h2>
<?php while ($row = $deliveries->fetch_assoc()): ?>
  <div style="border:1px solid #ccc; margin:10px; padding:10px; border-radius:8px;">
    <strong>Listing:</strong> <?= htmlspecialchars($row['title']) ?><br>
    <strong>To:</strong> <?= htmlspecialchars($row['name']) ?> (<?= htmlspecialchars($row['address']) ?>)<br>

    <form method="POST" action="mark_delivered.php" style="margin-top:10px;">
      <input type="hidden" name="request_id" value="<?= $row['id'] ?>">
      <button type="submit" style="background:#FFA500; color:white; padding:5px 10px; border:none; border-radius:5px;">Mark as Delivered</button>
    </form>
  </div>
<?php endwhile; ?>

<?php include('nav_driver.php'); ?>
