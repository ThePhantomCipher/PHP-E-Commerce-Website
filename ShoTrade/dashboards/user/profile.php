<?php
session_start();
require_once '../../includes/db.php';
$userId = $_SESSION['user_id'];

$stmt = $conn->prepare("SELECT name, surname, email, address, profile_image FROM users WHERE id=?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result()->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $name = $_POST['name'];
  $surname = $_POST['surname'];
  $address = $_POST['address'];
  $password = !empty($_POST['password']) ? password_hash($_POST['password'], PASSWORD_DEFAULT) : null;

  $imageFile = $_FILES['profile_image'];
  $profileImage = $result['profile_image'];

  if ($imageFile['size'] > 0) {
    $ext = pathinfo($imageFile['name'], PATHINFO_EXTENSION);
    $newFileName = uniqid() . '.' . $ext;
    move_uploaded_file($imageFile['tmp_name'], "../../uploads/" . $newFileName);
    $profileImage = $newFileName;
  }

  $sql = "UPDATE users SET name=?, surname=?, address=?, profile_image=?" . ($password ? ", password=?" : "") . " WHERE id=?";
  $stmt = $conn->prepare($sql);

  if ($password) {
    $stmt->bind_param("sssssi", $name, $surname, $address, $profileImage, $password, $userId);
  } else {
    $stmt->bind_param("ssssi", $name, $surname, $address, $profileImage, $userId);
  }

  $stmt->execute();
  echo "<p style='color: green; text-align:center;'>Profile updated.</p>";

  $stmt = $conn->prepare("SELECT name, surname, email, address, profile_image FROM users WHERE id=?");
  $stmt->bind_param("i", $userId);
  $stmt->execute();
  $result = $stmt->get_result()->fetch_assoc();
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>My Profile</title>
  <style>
    body { font-family: Arial, sans-serif; background: #f0f2f5; margin: 0; }
    .profile-container { max-width: 800px; margin: 40px auto; background: white; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1); overflow: hidden; }
    .profile-header { background: #ffb347; color: white; padding: 20px; text-align: center; }
    .profile-header h2 { margin: 0; }
    .profile-form, .listings-section { padding: 20px; }
    .profile-form label { display: block; margin: 10px 0 5px; font-weight: bold; }
    .profile-form input { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; }
    .profile-form button { margin-top: 15px; padding: 10px 20px; background: #4267B2; color: white; border: none; border-radius: 5px; cursor: pointer; }
    .profile-form button:hover { background: #365899; }
    .listings-section h3 { border-bottom: 2px solid #4267B2; padding-bottom: 5px; color: #333; }
    .listing-item { background: #f9f9f9; padding: 10px; margin: 10px 0; border-radius: 5px; display: flex; align-items: center; justify-content: space-between; }
    .listing-item img { max-width: 80px; border-radius: 5px; margin-right: 10px; }
    .listing-actions button { margin-left: 10px; padding: 5px 10px; border: none; border-radius: 5px; cursor: pointer; }
    .edit-btn { background: #ffcc80; }
    .delete-btn { background: #ff8a65; }
    .profile-picture { text-align: center; margin-bottom: 15px; }
    .profile-picture img { border-radius: 50%; width: 100px; height: 100px; object-fit: cover; }

    #listingModal { display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:#00000088; }
    #listingModal form {
      background:white; width:400px; margin:100px auto; padding:20px; border-radius:10px;
      border-top: 5px solid #ffb347; box-shadow: 0 5px 10px rgba(0,0,0,0.2);
    }
    #listingModal h3 { color: #4267B2; text-align: center; }
    #listingModal input, #listingModal textarea {
      width: 100%; margin: 10px 0; padding: 10px; border: 1px solid #ccc; border-radius: 5px;
    }
    #listingModal button { margin: 10px 5px 0 0; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; }
    #listingModal button[type="submit"] { background: #4267B2; color: white; }
    #listingModal button[type="button"] { background: #ccc; }
  </style>
</head>
<body>
  <div class="profile-container">
    <div class="profile-header">
      <h2>Welcome, <?= htmlspecialchars($result['name']) ?>!</h2>
    </div>

    <div class="profile-form">
      <form method="POST" enctype="multipart/form-data">
        <div class="profile-picture">
          <img src="../../uploads/<?= htmlspecialchars($result['profile_image']) ?>" alt="Profile Picture">
        </div>

        <label>Profile Picture</label>
        <input type="file" name="profile_image">

        <label>Name</label>
        <input type="text" name="name" value="<?= htmlspecialchars($result['name']) ?>">

        <label>Surname</label>
        <input type="text" name="surname" value="<?= htmlspecialchars($result['surname']) ?>">

        <label>Email</label>
        <input type="text" value="<?= htmlspecialchars($result['email']) ?>" disabled>

        <label>Address</label>
        <input type="text" name="address" value="<?= htmlspecialchars($result['address']) ?>">

        <label>New Password</label>
        <input type="password" name="password" placeholder="Leave blank to keep current">

        <button type="submit">Update Profile</button>
      </form>
    </div>

    <div class="listings-section">
      <h3>My Listings</h3>
      <ul>
        <?php
        $listStmt = $conn->prepare("SELECT id, title, image FROM listings WHERE user_id=?");
        $listStmt->bind_param("i", $userId);
        $listStmt->execute();
        $listingResult = $listStmt->get_result();
        while ($listing = $listingResult->fetch_assoc()) {
          echo "<li class='listing-item'>";
          if (!empty($listing['image'])) {
            echo "<img src='../../uploads/" . htmlspecialchars($listing['image']) . "'>";
          }
          echo "<span>" . htmlspecialchars($listing['title']) . "</span>";
          echo "<div class='listing-actions'>
                  <button class='edit-btn' onclick=\"editListing(" . $listing['id'] . ")\">Edit</button>
                  <button class='delete-btn' onclick=\"deleteListing(" . $listing['id'] . ")\">Delete</button>
                </div>";
          echo "</li>";
        }
        ?>
      </ul>
    </div>
  </div>

  <script>
    function deleteListing(id) {
      if (confirm("Delete this listing?")) {
        fetch('delete_listing.php?id=' + id).then(() => location.reload());
      }
    }

    function editListing(id) {
      window.location.href = 'edit_listing.php?id=' + id;
    }
  </script>
</body>
</html>
