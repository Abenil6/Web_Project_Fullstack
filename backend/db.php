<?php
$host = "127.0.0.1";
$username = "pmauser";
$password = "Abeni@12345";
$database = "sabana_resort";

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>