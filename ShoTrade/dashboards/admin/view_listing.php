<?php
require_once '../../includes/db.php';
session_start();

if (!isset($_GET['id'])) {
  echo "No listing selected.";
  exit;
}

$id = intval($_GET['id']);
$listing = $conn->query("SELECT * FROM listings WHERE id = $id")->fetch_assoc();

if (!$listing) {
  echo "Listing not found.";
  exit;
}

$imagePath = !empty($listing['image']) ? "../../uploads/" . $listing['image'] : "https://via.placeholder.com/400x300?text=No+Image";
?>

<!DOCTYPE html>
<html>
<head>
  <title>Listing Details</title>
  <style>
    body { font-family: Arial, sans-serif; background: #f4f4f4; padding: 40px; }
    .box {
      background: white;
      padding: 30px;
      border-radius: 10px;
      max-width: 600px;
      margin: auto;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
    h2 { text-align: center; margin-bottom: 20px; }
    .info p { font-size: 18px; margin: 12px 0; }
    .label { font-weight: bold; color: #555; }
    .listing-img {
      display: block;
      width: 100%;
      height: auto;
      max-height: 350px;
      object-fit: cover;
      border-radius: 10px;
      margin-bottom: 20px;
    }
  </style>
</head>
<body>

  <div class="box">
    <h2>Listing Details</h2>
    <img src="<?= $imagePath ?>" class="listing-img" alt="Listing Image">
    <div class="info">
      <p><span class="label">Title:</span> <?= $listing['title'] ?></p>
      <p><span class="label">Description:</span> <?= $listing['description'] ?></p>
      <p><span class="label">Price:</span> R<?= $listing['price'] ?></p>
      <p><span class="label">Posted:</span> <?= $listing['created_at'] ?></p>
    </div>
  </div>

</body>
</html>


