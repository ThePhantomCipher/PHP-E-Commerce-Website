<?php
require_once '../../includes/db.php';
session_start();

$requestId = $_POST['request_id'];
$stmt = $conn->prepare("UPDATE delivery_requests SET status='delivered' WHERE id=?");
$stmt->bind_param("i", $requestId);
$stmt->execute();

header("Location: my_deliveries.php");
exit;
