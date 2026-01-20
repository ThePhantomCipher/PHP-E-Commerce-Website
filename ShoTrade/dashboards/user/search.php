<?php include('header_user.php'); ?>
<?php include('sidebar_user.php'); ?>

<?php
require_once '../../includes/db.php';

$q = isset($_GET['q']) ? '%' . $_GET['q'] . '%' : '%';
$min = is_numeric($_GET['min_price'] ?? '') ? (int)$_GET['min_price'] : 0;
$max = is_numeric($_GET['max_price'] ?? '') ? (int)$_GET['max_price'] : 9999999;

$orderBy = "l.created_at DESC";
$sort = $_GET['sort'] ?? '';
if ($sort === 'lowest') $orderBy = "l.price ASC";
elseif ($sort === 'highest') $orderBy = "l.price DESC";

$stmt = $conn->prepare("SELECT l.*, u.name, u.address, u.id AS seller_id 
                        FROM listings l 
                        JOIN users u ON l.user_id = u.id 
                        WHERE (l.title LIKE ? OR l.description LIKE ?)
                          AND l.price BETWEEN ? AND ?
                        ORDER BY $orderBy");
$stmt->bind_param("ssii", $q, $q, $min, $max);
$stmt->execute();
$listings = $stmt->get_result();


?>
<h2 style= "font-weight: bold; font-size: 30px; padding-left:10px;">Search Results</h2>
<br>
<form method="GET" action="search.php" style="margin-bottom: 20px; padding-left: 20px;">
  <input type="text" name="q" placeholder="Search listings..." value="<?= htmlspecialchars($_GET['q'] ?? '') ?>" style="padding: 10px; width: 30%; border: 1px solid #ccc; border-radius: 5px;">

  <input type="number" name="min_price" placeholder="Min price" value="<?= htmlspecialchars($_GET['min_price'] ?? '') ?>" style="padding: 10px; width: 15%; border: 1px solid #ccc; border-radius: 5px;">
  <input type="number" name="max_price" placeholder="Max price" value="<?= htmlspecialchars($_GET['max_price'] ?? '') ?>" style="padding: 10px; width: 15%; border: 1px solid #ccc; border-radius: 5px;">

  <select name="sort" style="padding: 10px; border-radius: 5px;">
    <option value="">Sort By</option>
    <option value="newest" <?= ($_GET['sort'] ?? '') === 'newest' ? 'selected' : '' ?>>Newest</option>
    <option value="lowest" <?= ($_GET['sort'] ?? '') === 'lowest' ? 'selected' : '' ?>>Price: Low to High</option>
    <option value="highest" <?= ($_GET['sort'] ?? '') === 'highest' ? 'selected' : '' ?>>Price: High to Low</option>
  </select>

  <button type="submit" style="padding: 10px 20px; background: #4267B2; color: white; border: none; border-radius: 5px;">Search</button>
</form>

<div style="display: flex; flex-wrap: wrap; gap: 20px; padding-left: 20px;">
  <?php while ($row = $listings->fetch_assoc()): ?>
    <div style="width: 250px; border: 1px solid #ccc; padding: 10px; border-radius: 10px;">
      <?php if ($row['image']): ?>
        <img src="../../uploads/<?= htmlspecialchars($row['image']) ?>" style="width:100%; height:150px; object-fit:cover;">
      <?php endif; ?>
      <h3><?= htmlspecialchars($row['title']) ?></h3>
      <p>R<?= htmlspecialchars($row['price']) ?></p>
      <p><small>By: <?= htmlspecialchars($row['name']) ?>, <?= htmlspecialchars($row['address']) ?></small></p><br><br>

      <a href="messages.php?user=<?= $row['seller_id'] ?>" style="background:#1976d2; color:white; padding:5px 10px; border-radius:5px; text-decoration:none;">Message Seller</a><br><br>
      <form method="POST" action="add_to_cart.php" style="display:inline;">
        <input type="hidden" name="listing_id" value="<?= $row['id'] ?>">
        <button type="submit" style="background:#ffb347; border:none; padding:5px 10px; border-radius:5px; cursor:pointer;">Add to Cart</button>
      </form>
    </div>
  <?php endwhile; ?>
</div><br><br><br>

<?php include('nav_user.php'); ?>
