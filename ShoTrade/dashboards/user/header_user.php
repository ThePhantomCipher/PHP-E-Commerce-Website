<?php
session_start();
if (!isset($_SESSION['user_id'])) {
  header("Location: ../../login.php");
  exit;}
require_once '../../includes/db.php';
$userId = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT profile_image FROM users WHERE id=?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$image = $stmt->get_result()->fetch_assoc()['profile_image'];
?>

<header class="bg-white shadow p-4 flex justify-between items-center">
  <div>
    <img src = "/ShoTrade/assets/images/Sho'Trade Icon.png" class = "w-16 h-16 float-left">
    <span class="text-xl font-bold text-yellow-600 float-right">Sho'Trade</span>
  </div>
  <div class="flex gap-4">
    <a href="profile.php" class ="py-0"><img src="../../uploads/<?= htmlspecialchars($image) ?>" alt="Profile" style="width:35px; height:35px; border-radius:50%; object-fit:cover;"></a>
    <button class="text-sm bg-blue-600 text-white px-3 py-2 rounded" onclick="document.getElementById('listingModal').style.display='block'"
    >+ Upload</button>
    <a href="../../logout.php" class="text-red-500 hover:text-red-700 text-sm py-2">Logout</a>
    <button id="openSidebarBtn" onclick="openSidebar()" class="hidden md:block bg-white p-2 shadow z-50">
          ☰
      </button>
  </div>
  <script src="/ShoTrade/assets/js/app.js"></script>
  <script src="https://cdn.tailwindcss.com"></script>
</header>

<div id="listingModal" style="display: none; position:fixed; top:0; left:0; width:100%; height:100%; background:#00000088; justify-content:center; align-items:center; z-index:999;">
  <form method="POST" action="add_listing.php" enctype="multipart/form-data" style="background:white; max-width: 450px; margin: 80px auto; padding: 25px; border-radius: 10px; box-shadow: 0 0 15px rgba(0,0,0,0.3); border-left: 6px solid #ffb347;">
    <h3 style="color: #4267B2; text-align: center; margin-top: 0; font-weight: bold;">Add New Listing</h3>

    <br>
    <label style="color: #4267B2; font-weight: bold;">Image</label>
    <input type="file" name="image" accept="image/*" style="margin-bottom: 15px;">
    <br>
    <label style="color: #4267B2; font-weight: bold;">Title</label>
    <input type="text" name="title" placeholder="Listing title" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">

    <label style="color: #4267B2; font-weight: bold;">Description</label>
    <textarea name="description" placeholder="Brief description..." required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;"></textarea>

    <label style="color: #4267B2; font-weight: bold;">Price</label>
    <input type="number" name="price" placeholder="Enter price" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
    <br>
    <br>
    <div style="text-align: right;">
      <button type="submit" style="background-color: #4267B2; color: white; padding: 10px 20px; border: none; border-radius: 5px; margin-right: 10px; cursor: pointer;">Post</button>
      <button type="button" onclick="document.getElementById('listingModal').style.display='none'" style="background-color: #ffb347; color: black; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer;">Cancel</button>
    </div>
  </form>
</div>
