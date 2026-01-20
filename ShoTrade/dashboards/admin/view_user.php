<?php
require_once '../../includes/db.php';
session_start();

if (!isset($_GET['id'])) {
  echo "No user selected.";
  exit;
}

$id = intval($_GET['id']);
$user = $conn->query("SELECT * FROM users WHERE id = $id")->fetch_assoc();

if (!$user) {
  echo "User not found.";
  exit;
}

$imagePath = !empty($user['image']) ? "../../uploads/" . $user['profile_image'] : "https://via.placeholder.com/200x200?text=No+Image";
?>

<!DOCTYPE html>
<html>
<head>
  <title>User Details</title>
  <style>
    body { font-family: Arial, sans-serif; background: #f4f4f4; padding: 40px; }
    .box {
      background: white;
      padding: 30px;
      border-radius: 10px;
      max-width: 500px;
      margin: auto;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
      text-align: center;
    }
    h2 { margin-bottom: 20px; }
    .profile-img {
      width: 160px;
      height: 160px;
      border-radius: 50%;
      object-fit: cover;
      margin-bottom: 20px;
      box-shadow: 0 0 5px rgba(0,0,0,0.2);
    }
    .info p { font-size: 18px; margin: 12px 0; }
    .label { font-weight: bold; color: #555; }
  </style>
</head>
<body>

  <div class="box">
    <img src="<?= $imagePath ?>" class="profile-img" alt="User Profile Picture">
    <h2>User Details</h2>
    <div class="info">
      <p><span class="label">Name:</span> <?= $user['name'] . ' ' . $user['surname'] ?></p>
      <p><span class="label">Email:</span> <?= $user['email'] ?></p>
      <p><span class="label">Role:</span> <?= ucfirst($user['role']) ?></p>
      <p><span class="label">Joined:</span> <?= $user['created_at'] ?></p>
    </div>
  </div>

</body>
</html>
