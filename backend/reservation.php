<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('Please login first.'); window.location.href = '../login.html';</script>";
    exit;
}

if (isset($_POST['check'])) {
    include 'db.php';

    $user_id = $_SESSION['user_id'];
    $check_in = $_POST['check_in'];
    $check_out = $_POST['check_out'];
    $adults = $_POST['adults'];
    $childs = $_POST['childs'];
    $rooms = $_POST['rooms'];

    $stmt = $conn->prepare("INSERT INTO reservations (user_id, check_in, check_out, adults, childs, rooms) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("issiii", $user_id, $check_in, $check_out, $adults, $childs, $rooms);

    if ($stmt->execute()) {
        echo "<script>alert('Reservation submitted successfully!'); window.location.href = '../dashboard.php';</script>";

    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>