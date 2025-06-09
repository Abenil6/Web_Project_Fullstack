<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'db.php';

    $name = $_POST['Name'];
    $email = $_POST['Email'];
    $number = $_POST['Number'];
    $msg = $_POST['msg'];

    $stmt = $conn->prepare("INSERT INTO messages (name, email, phone, message) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $email, $number, $msg);

    if ($stmt->execute()) {
        echo "<script>alert('Message sent successfully!'); window.location.href = '../index.html';</script>";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>