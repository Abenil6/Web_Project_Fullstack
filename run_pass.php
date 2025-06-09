<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include "backend/db.php";


$first = 'Admin';
$last = 'A';
$email = 'admin@123.com';
$phone = '';
$password = password_hash('admin123', PASSWORD_DEFAULT); // hashed password
$role = 'admin';

$stmt = $conn->prepare("INSERT INTO users (first_name, last_name, email, phone, password, role) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssss", $first, $last, $email, $phone, $password, $role);

if ($stmt->execute()) {
    echo "✅ Admin account created successfully!";
} else {
    echo "❌ Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>