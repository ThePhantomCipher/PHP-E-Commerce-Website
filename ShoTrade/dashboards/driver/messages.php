<?php 
// For driver
include 'header_driver.php';
include'sidebar_driver.php'; 
$role = 'driver';
?>

<main class="p-4">
  <h1 class="text-2xl font-bold mb-4">Messages</h1>
  
  <?php
require_once '../../includes/db.php';
$userId = $_SESSION['user_id'];

// Get all users the current user has chatted with
$stmt = $conn->prepare("SELECT id, name FROM users WHERE id != ?");
$stmt->bind_param("i", $userId);

$stmt->execute();
$users = $stmt->get_result();

// Selected chat partner
$chatWith = $_GET['user'] ?? null;
?>

<div style="display: flex; height: 80vh;">
  <!-- User list -->
  <div style="width: 25%; border-right: 1px solid #ccc; overflow-y: auto;">
    <h3 style="padding: 10px;">Chats</h3>
    <?php while ($row = $users->fetch_assoc()): ?>
      <div style="padding: 10px; border-bottom: 1px solid #eee;">
        <a href="messages.php?user=<?= $row['id'] ?>" style="text-decoration: none; color: #333;">
          <?= htmlspecialchars($row['name']) ?>
        </a>
      </div>
    <?php endwhile; ?>
  </div>

  <!-- Chat box -->
  <div style="width: 75%; padding: 20px; display: flex; flex-direction: column; justify-content: space-between;">
    <?php if ($chatWith): ?>
      <div style="flex-grow: 1; overflow-y: auto; border: 1px solid #ccc; padding: 15px; border-radius: 10px;">
        <?php
        $stmt = $conn->prepare("SELECT * FROM messages WHERE 
                                (sender_id = ? AND receiver_id = ?) OR 
                                (sender_id = ? AND receiver_id = ?) 
                                ORDER BY created_at ASC");
        $stmt->bind_param("iiii", $userId, $chatWith, $chatWith, $userId);
        $stmt->execute();
        $msgs = $stmt->get_result();
        while ($msg = $msgs->fetch_assoc()):
        ?>
          <div style="margin: 10px 0; text-align: <?= $msg['sender_id'] == $userId ? 'right' : 'left' ?>;">
            <span style="background: <?= $msg['sender_id'] == $userId ? '#ffb347' : '#4267B2' ?>; color: white; padding: 8px 12px; border-radius: 15px; display: inline-block;">
              <?= htmlspecialchars($msg['message']) ?>
            </span>
          </div>
        <?php endwhile; ?>
      </div>

      <!-- Message form -->
<!-- In messages_driver.php, update the form action -->
      <form method="POST" action="../../chat/send_message.php" style="margin-top: 15px; display: flex;">
          <input type="hidden" name="receiver_id" value="<?= $chatWith ?>">
          <input type="text" name="message" placeholder="Type a message..." required style="flex-grow: 1; padding: 10px; border-radius: 20px; border: 1px solid #ccc;">
          <button type="submit" style="margin-left: 10px; padding: 10px 20px; background: #4267B2; color: white; border: none; border-radius: 20px;">Send</button>
      </form>
    <?php else: ?>
      <p>Select a user to chat with.</p>
    <?php endif; ?>
  </div>
</div>

</main>
<?php include('nav_driver.php'); ?>
