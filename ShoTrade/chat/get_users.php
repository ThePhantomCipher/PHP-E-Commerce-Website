<?php
session_start();
require_once '../includes/db.php';

$currentUserId = $_SESSION['user_id'];
$currentUserRole = $_SESSION['role']; // Make sure this is set at login

// Fetch all users except self, and allow users/admins/drivers to chat with each other
$sql = "
SELECT u.id, CONCAT(u.name, ' ', u.surname) AS fullname, u.role,
       (SELECT COUNT(*) FROM messages m 
        WHERE m.sender_id = u.id AND m.receiver_id = ? AND m.is_read = 0) AS unread
FROM users u
WHERE u.id != ?
ORDER BY unread DESC, fullname ASC
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $currentUserId, $currentUserId);
$stmt->execute();
$result = $stmt->get_result();

$users = [];
while ($row = $result->fetch_assoc()) {
    $users[] = $row;
}
echo json_encode($users);
