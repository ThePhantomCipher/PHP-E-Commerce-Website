<?php
session_start();
require_once '../../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $userId = $_SESSION['user_id'];
  $title = $_POST['title'];
  $desc = $_POST['description'];
  $price = $_POST['price'];
  $image = null;

  if ($_FILES['image']['size'] > 0) {
    $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
    $image = uniqid() . '.' . $ext;
    move_uploaded_file($_FILES['image']['tmp_name'], "../../uploads/" . $image);
  }

  $stmt = $conn->prepare("INSERT INTO listings (user_id, title, description, price, image, created_at) VALUES (?, ?, ?, ?, ?, NOW())");
  $stmt->bind_param("issss", $userId, $title, $desc, $price, $image);
  $stmt->execute();
  header("Location: profile.php");
  exit;
}
?>
