<?php
session_start();
require_once '../../includes/db.php';

$userId = $_SESSION['user_id'] ?? 0;

// Fetch all users except the logged-in admin
$stmt = $conn->prepare("SELECT id, name FROM users WHERE id != ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$users = $stmt->get_result();

$chatWith = $_GET['user'] ?? null;
?>
<!DOCTYPE html>
<html>
<head>
  <title>Admin Messages</title>
  <style>
    body { margin: 0; font-family: Arial, sans-serif; display: flex; background: #f4f4f4; }
    .sidebar { width: 220px; background: #333; color: #fff; height: 100vh; position: fixed; padding-top: 20px; }
    .sidebar h2 { text-align: center; margin-bottom: 30px; font-size: 22px; color: #fff; }
    .sidebar a { display: block; padding: 15px 20px; color: #fff; text-decoration: none; border-bottom: 1px solid #444; }
    .sidebar a:hover { background: #444; }

    .main { margin-left: 220px; padding: 30px; width: 100%; }
    .user-list { background: #fff; padding: 15px; border: 1px solid #ddd; max-height: 400px; overflow-y: auto; }
    .user-list a { display: block; padding: 8px; margin-bottom: 5px; background: #f9f9f9; border-radius: 5px; text-decoration: none; color: #333; }
    .user-list a:hover { background: #eee; }

    .chat-box { background: #fff; border: 1px solid #ddd; padding: 15px; height: 350px; overflow-y: auto; margin-bottom: 15px; }
    .message { margin-bottom: 10px; }
    .message strong { color: #333; }
    textarea { width: 100%; padding: 10px; margin-bottom: 10px; border: 1px solid #ddd; border-radius: 5px; resize: none; }
    button { background: #333; color: #fff; border: none; padding: 10px 20px; cursor: pointer; border-radius: 5px; }
    button:hover { background: #555; }
  </style>
</head>
<body>

  <div class="sidebar">
    <h2>Admin Panel</h2>
    <a href="admin_dashboard.php">Dashboard</a>
    <a href="manage_users.php">Manage Users</a>
    <a href="manage_listings.php">Manage Listings</a>
    <a href="messages.php">Messages</a>
    <a href="admin_reports.php">Reports</a>
    <a href="../../logout.php">Logout</a>
  </div>

  <div class="main">
    <h1>Messages</h1>

    <div style="display: flex; gap: 20px;">
      <!-- User list -->
      <div class="user-list" style="flex: 1;">
        <h3>Users</h3>
        <?php while ($row = $users->fetch_assoc()): ?>
          <a href="messages.php?user=<?= $row['id'] ?>"><?= htmlspecialchars($row['name']) ?></a>
        <?php endwhile; ?>
      </div>

      <!-- Chat section -->
      <div style="flex: 2;">
        <?php if ($chatWith): ?>
          <?php
            $stmt = $conn->prepare("SELECT * FROM messages 
              WHERE (sender_id = ? AND receiver_id = ?) 
              OR (sender_id = ? AND receiver_id = ?) 
              ORDER BY created_at");
            $stmt->bind_param("iiii", $userId, $chatWith, $chatWith, $userId);
            $stmt->execute();
            $messages = $stmt->get_result();
          ?>
          <h3>Chat with User <?= htmlspecialchars($chatWith) ?></h3>
          <div class="chat-box">
            <?php while ($msg = $messages->fetch_assoc()): ?>
              <div class="message">
                <strong><?= $msg['sender_id'] == $userId ? 'You' : 'Them' ?>:</strong>
                <?= htmlspecialchars($msg['message']) ?>
              </div>
            <?php endwhile; ?>
          </div>
          <form method="POST" action="../../chat/send_message.php">
            <input type="hidden" name="receiver_id" value="<?= $chatWith ?>">
            <textarea name="message" rows="3" required></textarea>
            <button type="submit">Send</button>
          </form>
        <?php else: ?>
          <p>Select a user to start chatting.</p>
        <?php endif; ?>
      </div>
    </div>
  </div>

</body>
</html>
