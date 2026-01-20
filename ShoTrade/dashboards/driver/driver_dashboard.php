<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
  <meta charset="UTF-8">
  <title>Driver Dashboard</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <script src="/ShoTrade/assets/js/app.js"></script>
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<?php
require_once '../../includes/db.php';


$stmt = $conn->prepare("SELECT dr.id, l.title, u.name, u.address 
                        FROM delivery_requests dr 
                        JOIN listings l ON dr.listing_id = l.id 
                        JOIN users u ON dr.user_id = u.id 
                        WHERE dr.status = 'pending' 
                        ORDER BY dr.created_at DESC");
$stmt->execute();
$result = $stmt->get_result();
?>

<body class="min-h-screen bg-gray-100 flex flex-col md:flex-row">

<!-- Sidebar for Desktop -->
<?php include('sidebar_driver.php'); ?>

<!-- Main Content -->
<div class="flex-1 flex flex-col">
  <!-- Header -->
<?php include('header_driver.php'); ?>

  <!-- Page Content -->
  <main id="mainContent" class="transition-all duration-300 p-4">
  
  

<h2 style="font-weight: bold; font-size: 30px; padding-left:10px;">Pending Delivery Requests</h2>
  <?php while ($row = $result->fetch_assoc()): ?>
    <div style="border:1px solid #ccc; margin:10px; padding:10px; border-radius:8px;">
      <strong>Listing:</strong> <?= htmlspecialchars($row['title']) ?><br>
      <strong>Customer:</strong> <?= htmlspecialchars($row['name']) ?><br>
      <strong>Address:</strong> <?= htmlspecialchars($row['address']) ?><br>
      
      <form method="POST" action="accept_delivery.php" style="display:inline;">
      <input type="hidden" name="request_id" value="<?= $row['id'] ?>">
      <button type="submit" style="background:#4CAF50; color:white; padding:5px 10px; border:none; border-radius:5px;">Accept</button>
    </form>

    <form method="POST" action="reject_delivery.php" style="display:inline;">
      <input type="hidden" name="request_id" value="<?= $row['id'] ?>">
      <button type="submit" style="background:#f44336; color:white; padding:5px 10px; border:none; border-radius:5px;">Reject</button>
    </form>

<a href="messages.php?user=<?= $row['id'] ?>" style="background:#1976D2; color:white; padding:5px 10px; border-radius:5px; text-decoration:none;">Chat</a>

    </div>
  <?php endwhile; ?>

 
  </main>

  <!-- Bottom Nav for Mobile -->
  <?php include('nav_driver.php'); ?>
</div>

</body>
</html>
