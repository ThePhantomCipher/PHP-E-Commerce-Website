<?php
require_once '../../includes/db.php';
session_start();
$userId = $_SESSION['user_id'];

if (isset($_GET['id'])) {
  $listingId = $_GET['id'];
  $stmt = $conn->prepare("DELETE FROM listings WHERE id=? AND user_id=?");
  $stmt->bind_param("ii", $listingId, $userId);
  $stmt->execute();
}
?>
