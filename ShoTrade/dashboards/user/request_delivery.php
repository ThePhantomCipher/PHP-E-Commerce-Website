<?php
require_once '../../includes/db.php';
session_start();

$userId = $_SESSION['user_id'];
$listingId = $_POST['listing_id'];

// Check for existing request
$check = $conn->prepare("SELECT * FROM delivery_requests WHERE user_id=? AND listing_id=?");
$check->bind_param("ii", $userId, $listingId);
$check->execute();
$exists = $check->get_result()->num_rows;

if (!$exists) {
  $stmt = $conn->prepare("INSERT INTO delivery_requests (user_id, listing_id, status, created_at) VALUES (?, ?, 'pending', NOW())");
  $stmt->bind_param("ii", $userId, $listingId);
  $stmt->execute();
}

header("Location: cart.php");
exit;
