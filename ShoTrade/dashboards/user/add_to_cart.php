<?php
session_start();
require_once '../../includes/db.php';

if (isset($_POST['listing_id'])) {
  $userId = $_SESSION['user_id'];
  $listingId = $_POST['listing_id'];

  $stmt = $conn->prepare("INSERT INTO cart (user_id, listing_id) VALUES (?, ?)");
  $stmt->bind_param("ii", $userId, $listingId);
  $stmt->execute();

  $_SESSION['cart_success'] = true;
}

header("Location: " . $_SERVER['HTTP_REFERER']);
exit;

?>
