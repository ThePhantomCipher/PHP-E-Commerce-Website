<?php
include('header_user.php');
include('sidebar_user.php');
require_once '../../includes/db.php';

$userId = $_SESSION['user_id'];

$stmt = $conn->prepare("SELECT c.id AS cart_id, l.*, u.name AS seller_name 
                        FROM cart c 
                        JOIN listings l ON c.listing_id = l.id 
                        JOIN users u ON l.user_id = u.id 
                        WHERE c.user_id = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

$totalAmount = 0;
?>
<h2 style="font-weight: bold; font-size: 30px; padding-left:20px;">My Cart</h2>

<?php while ($item = $result->fetch_assoc()): 
  $totalAmount += $item['price'];
?>
  <div style="border:1px solid #ccc; margin:10px; padding:10px; border-radius:10px;">
    <h3><?= htmlspecialchars($item['title']) ?></h3>
    <p>R<?= number_format($item['price'], 2) ?> | Seller: <?= htmlspecialchars($item['seller_name']) ?></p>
    <?php if ($item['image']): ?>
      <img src="../../uploads/<?= $item['image'] ?>" style="width:100px; height:auto;">
    <?php endif; ?><br><br>
    <form method="POST" action="request_delivery.php" style="display:inline;">
      <input type="hidden" name="listing_id" value="<?= $item['id'] ?>">
      <button type="submit" style="background:#4267B2; color:white; border:none; padding:5px 10px;">Request Delivery</button>
    </form>
    <form method="POST" action="remove_from_cart.php" style="display:inline;">
      <input type="hidden" name="cart_id" value="<?= $item['cart_id'] ?>">
      <button type="submit" style="background:#ff4d4d; color:white; border:none; padding:5px 10px;">Remove</button>
    </form>
  </div>
<?php endwhile; ?>

<!-- Total & Checkout -->
<div style="margin:20px; padding:20px; background:#f9f9f9; border-radius:10px; border:1px solid #ddd;">
  <h3>Total Amount: <span style="color:green;">R<?= number_format($totalAmount, 2) ?></span></h3>
  <?php if ($totalAmount > 0): ?>
    <button onclick="openModal()" style="background:#28a745; color:white; border:none; padding:10px 20px; border-radius:5px; font-size:16px;">Proceed to Checkout</button>
  <?php else: ?>
    <p>Your cart is empty.</p>
  <?php endif; ?>
</div>

<!-- Checkout Modal -->
<div id="checkoutModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.6);">
  <div style="background:#fff; width:400px; margin:100px auto; padding:20px; border-radius:10px; position:relative;">
    <h2>Choose Payment Method</h2>
    <form id="checkoutForm">
      <label><input type="radio" name="payment_method" value="card" required> Credit/Debit Card</label><br>
      <label><input type="radio" name="payment_method" value="eft" required> EFT/Bank Transfer</label><br>
      <label><input type="radio" name="payment_method" value="cod" required> Cash on Delivery</label><br><br>

      <input type="hidden" name="total" value="<?= $totalAmount ?>">

      <button type="submit" style="background:#28a745; color:white; border:none; padding:10px 20px; border-radius:5px;">Confirm</button>
      <button type="button" onclick="closeModal()" style="background:#ccc; border:none; padding:10px 20px; border-radius:5px;">Cancel</button>
    </form>
  </div>
</div>

<!-- Confirmation Modal -->
<div id="confirmationModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.6);">
  <div style="background:#fff; width:400px; margin:100px auto; padding:20px; border-radius:10px; text-align:center;">
    <h2>Order Confirmed 🎉</h2>
    <p>Your order has been placed successfully!</p>
    <button onclick="closeConfirmation()" style="background:#28a745; color:white; border:none; padding:10px 20px; border-radius:5px;">OK</button>
  </div>
</div>

<script>
function openModal() {
  document.getElementById('checkoutModal').style.display = 'block';
}
function closeModal() {
  document.getElementById('checkoutModal').style.display = 'none';
}

// Handle checkout confirmation
document.getElementById('checkoutForm').addEventListener('submit', function(e) {
  e.preventDefault();
  closeModal();
  document.getElementById('confirmationModal').style.display = 'block';
});

function closeConfirmation() {
  document.getElementById('confirmationModal').style.display = 'none';
  // Optional: redirect to orders page
  // window.location.href = "my_orders.php";
}
</script>
