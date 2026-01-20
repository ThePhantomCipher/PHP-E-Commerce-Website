<?php
require_once '../../includes/db.php';
session_start();

if (isset($_POST['cart_id'])) {
  $stmt = $conn->prepare("DELETE FROM cart WHERE id = ?");
  $stmt->bind_param("i", $_POST['cart_id']);
  $stmt->execute();
}

header("Location: cart.php");
exit;
