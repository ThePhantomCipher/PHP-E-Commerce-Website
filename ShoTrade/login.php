<?php
session_start();
require_once 'includes/db.php';

$email = $_POST['email'];
$password = $_POST['password'];

// Check if email exists in admin table first
$admin_stmt = $conn->prepare("SELECT * FROM admins WHERE email = ?");
$admin_stmt->bind_param("s", $email);
$admin_stmt->execute();
$admin_result = $admin_stmt->get_result();

if ($admin_result->num_rows === 1) {
    $admin = $admin_result->fetch_assoc();
    if (password_verify($password, $admin['password'])) {
        $_SESSION['admin_id'] = $admin['id'];
        $_SESSION['role'] = 'admin';
        header("Location: dashboards/admin/admin_dashboard.php");
        exit;
    }
}

// If not admin, check users table
$user_stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
$user_stmt->bind_param("s", $email);
$user_stmt->execute();
$user_result = $user_stmt->get_result();

if ($user_result->num_rows === 1) {
    $user = $user_result->fetch_assoc();
    if (password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $user['role']; // user or driver
        if ($user['role'] === 'driver') {
            header("Location: dashboards/driver/driver_dashboard.php");
        } else {
            header("Location: dashboards/user/user_dashboard.php");
        }
        exit;
    }
}

// Invalid credentials
echo "Invalid email or password.";
