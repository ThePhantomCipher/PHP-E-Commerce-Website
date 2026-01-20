<?php include('sidebar_user.php'); ?>
<?php include('header_user.php'); ?>

<?php
require_once '../../includes/db.php';

$stmt = $conn->prepare("SELECT listings.*, users.name, users.address, users.id AS seller_id FROM listings JOIN users ON listings.user_id = users.id ORDER BY listings.created_at DESC");
$stmt->execute();
$listings = $stmt->get_result();
?>


<h1 style="font-weight: bold; font-size: 30px; padding-left:10px;">Marketplace</h1><br>
<div style="display: flex; flex-wrap: wrap; gap: 20px; padding-left: 40px;">
  <?php while ($row = $listings->fetch_assoc()): ?>
    <div style="width: 250px; border: 1px solid #ccc; padding: 10px; border-radius: 10px;">
      <?php if ($row['image']): ?>
        <img src="../../uploads/<?= htmlspecialchars($row['image']) ?>" style="width:100%; height:150px; object-fit:cover;">
      <?php endif; ?>
      <h3><?= htmlspecialchars($row['title']) ?></h3><br>
      <p>R<?= htmlspecialchars($row['price']) ?></p>
      <p><small>By: <?= htmlspecialchars($row['name']) ?>, <?= htmlspecialchars($row['address']) ?></small></p> <br>

      <a href="messages.php?user=<?= $row['seller_id'] ?>" style="background:#1976d2; color:white; padding:5px 10px; border-radius:5px; text-decoration:none;">Message Seller</a><br><br>
      <form method="POST" action="add_to_cart.php" style="display:inline;">
        <input type="hidden" name="listing_id" value="<?= $row['id'] ?>">
        <button type="submit" style="background:#ffb347; border:none; padding:5px 10px; border-radius:5px; cursor:pointer;">Add to Cart</button>
      </form>
    </div>
  <?php endwhile; ?>
      </div><br><br><br>

      <div id="toast" style="
  visibility: hidden;
  min-width: 250px;
  margin-left: -125px;
  background-color: #4BB543;
  color: white;
  text-align: center;
  border-radius: 8px;
  padding: 16px;
  position: fixed;
  z-index: 1000;
  left: 50%;
  bottom: 30px;
  font-size: 17px;
  box-shadow: 0 0 10px rgba(0,0,0,0.2);
  transition: visibility 0s, opacity 0.5s linear;
">
  ✅ Item added to cart!
</div>

<script>
  <?php if (isset($_SESSION['cart_success'])): ?>
    const toast = document.getElementById("toast");
    toast.style.visibility = "visible";
    toast.style.opacity = "1";
    setTimeout(() => {
      toast.style.visibility = "hidden";
      toast.style.opacity = "0";
    }, 3000);
  <?php unset($_SESSION['cart_success']); endif; ?>
</script>


<?php include('nav_user.php'); ?>