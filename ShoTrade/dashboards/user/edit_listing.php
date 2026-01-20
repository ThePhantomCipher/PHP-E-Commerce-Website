<?php
require_once '../../includes/db.php';
session_start();
$userId = $_SESSION['user_id'];
$listingId = $_GET['id'];

$stmt = $conn->prepare("SELECT * FROM listings WHERE id=? AND user_id=?");
$stmt->bind_param("ii", $listingId, $userId);
$stmt->execute();
$listing = $stmt->get_result()->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $title = $_POST['title'];
  $desc = $_POST['description'];
  $price = $_POST['price'];

  if ($_FILES['image']['size'] > 0) {
    $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
    $image = uniqid() . "." . $ext;
    move_uploaded_file($_FILES['image']['tmp_name'], "../../uploads/" . $image);
  } else {
    $image = $listing['image'];
  }

  $stmt = $conn->prepare("UPDATE listings SET title=?, description=?, price=?, image=? WHERE id=? AND user_id=?");
  $stmt->bind_param("ssssii", $title, $desc, $price, $image, $listingId, $userId);
  $stmt->execute();
  header("Location: profile.php");
  exit;
}
?>

<form method="POST" enctype="multipart/form-data">
  <input name="title" value="<?= htmlspecialchars($listing['title']) ?>" required><br>
  <textarea name="description" required><?= htmlspecialchars($listing['description']) ?></textarea><br>
  <input type="number" name="price" value="<?= $listing['price'] ?>" required><br>
  <input type="file" name="image"><br>
  <button type="submit">Update Listing</button>
</form>
