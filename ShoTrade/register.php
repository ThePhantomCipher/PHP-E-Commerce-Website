<?php
session_start();
require 'includes/db.php';

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST["name"] ?? '');
    $surname = trim($_POST["surname"] ?? '');
    $address = $_POST['address'];
    $email = trim($_POST['email']);
    $hashedpassword = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = strtolower($_POST['role']);

    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ? and role = ?");
    $stmt->bind_param("ss", $email, $role);
    $stmt->execute();
    if ($stmt->get_result()->num_rows > 0) {
        echo "Email already registered.";
        exit;
}

    $stmt = $conn->prepare("INSERT INTO users (name, surname, address, email, password, role) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $name, $surname, $address, $email, $hashedpassword, $role);
    $stmt->execute();

    $_SESSION['user_id'] = $stmt->insert_id;
    $_SESSION['name'] = $name;
    $_SESSION['role'] = $role;

    switch ($role) {
        case 'user':
            header("Location: dashboards/user/user_dashboard.php");
            break;
        case 'driver':
            header("Location: dashboards/driver/driver_dashboard.php");
            break;
        case 'admin':
            header("Location: dashboards/admin/admin_dashboard.php");
            break;
    } exit;
}