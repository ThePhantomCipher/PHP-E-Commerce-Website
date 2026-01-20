<?php
// File: chat/get_messages.php
include '../includes/db.php';
session_start();

$user_id = $_SESSION['user_id'];
$chat_with = $_GET['chat_with'];

$stmt = $conn->prepare("SELECT * FROM messages WHERE (sender_id = ? AND receiver_id = ?) OR (sender_id = ? AND receiver_id = ?) ORDER BY timestamp ASC");
$stmt->bind_param("iiii", $user_id, $chat_with, $chat_with, $user_id);
$stmt->execute();
$result = $stmt->get_result();

$messages = [];
while ($row = $result->fetch_assoc()) {
    $messages[] = $row;
}

header('Content-Type: application/json');
echo json_encode($messages);

// Mark messages as read
$update = $conn->prepare("UPDATE messages SET is_read = 1 WHERE sender_id = ? AND receiver_id = ? AND is_read = 0");
$update->bind_param("ii", $chat_with, $user_id);
$update->execute();
?>