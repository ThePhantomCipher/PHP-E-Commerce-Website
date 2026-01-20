<?php
require_once '../../includes/db.php';
session_start();

$driverId = $_SESSION['user_id'];
$requestId = $_POST['request_id'];

$stmt = $conn->prepare("UPDATE delivery_requests SET status='accepted', driver_id=? WHERE id=?");
$stmt->bind_param("ii", $driverId, $requestId);
$stmt->execute();

header("Location: my_deliveries.php");
exit;
