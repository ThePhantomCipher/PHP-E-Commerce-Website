<?php
require_once('../includes/db.php');
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

$sender = $_SESSION['user_id'];
$receiver = $_POST['receiver_id'];
$message = trim($_POST['message']);
$role = $_SESSION['role'];

if ($message !== '') {
    $stmt = $conn->prepare("INSERT INTO messages (sender_id, receiver_id, message, created_at) VALUES (?, ?, ?, NOW())");
    $stmt->bind_param("iis", $sender, $receiver, $message);
    $stmt->execute();
}

// Redirect based on role with proper path
switch ($role) {
    case 'admin':
        header("Location: ../dashboards/admin/messages.php?user=$receiver");
        break;
    case 'driver':
        header("Location: ../dashboards/driver/messages.php?user=$receiver");
        break;
    default:
        header("Location: ../dashboards/user/messages.php?user=$receiver");
}
exit;
?>