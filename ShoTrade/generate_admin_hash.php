<?php
$password = 'admin123'; // Change to your desired password
$hash = password_hash($password, PASSWORD_DEFAULT);
echo "Hashed password: " . $hash;
?>
