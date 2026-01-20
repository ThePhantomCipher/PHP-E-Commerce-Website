<?php
require_once '../../includes/db.php';
session_start();

$requestId = $_POST['request_id'];
$stmt = $conn->prepare("UPDATE delivery_requests SET status='rejected' WHERE id=?");
$stmt->bind_param("i", $requestId);
$stmt->execute();

header("Location: driver_dashboard.php");
exit;
