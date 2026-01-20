<?php
session_start();
$_ROLE = 'driver';
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
    <a href="../../logout.php" class="text-red-500 hover:text-red-700 text-sm py-2">Logout</a>
    <button id="openSidebarBtn" onclick="openSidebar()" class="hidden md:block bg-white p-2 shadow z-50">
          ☰
      </button>
  </div>
  <script src="/ShoTrade/assets/js/app.js"></script>
  <script src="https://cdn.tailwindcss.com"></script>
</header>