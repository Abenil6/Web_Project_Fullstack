<?php
header('Content-Type: application/json'); // Important for JavaScript to parse response correctly

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'db.php';

    $first_name = $_POST["first_name"];
    $last_name = $_POST["last_name"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];

    // Check password match
    if ($password !== $confirm_password) {
        echo json_encode([
            'success' => false,
            'message' => 'Passwords do not match!',
            'errors' => ['confirm_password' => 'Passwords do not match.']
        ]);
        exit;
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO users (first_name, last_name, email, phone, password) VALUES (?, ?, ?, ?, ?)");

    if (!$stmt) {
        echo json_encode([
            'success' => false,
            'message' => 'Database error (prepare): ' . $conn->error
        ]);
        exit;
    }

    $stmt->bind_param("sssss", $first_name, $last_name, $email, $phone, $hashed_password);

    if ($stmt->execute()) {
        echo json_encode([
            'success' => true,
            'message' => 'Registration successful!',
            'redirect' => 'http://localhost/Web_Project_Fullstack/index.html'  // adjust path if needed
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Registration failed: ' . $stmt->error
        ]);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid request method.'
    ]);
}
