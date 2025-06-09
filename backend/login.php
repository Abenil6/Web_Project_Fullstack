<?php
session_start();
header('Content-Type: application/json');
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"] ?? '';
    $password = $_POST["password"] ?? '';

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    if (!$stmt) {
        echo json_encode(["success" => false, "message" => "Database error"]);
        exit;
    }

    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['first_name'];
            $_SESSION['role'] = $user['role']; // store role in session

            $redirectUrl = $user['role'] === 'admin'
                ? "http://localhost/Web_Project_Fullstack/admin/dashboard.php"
                : "http://localhost/Web_Project_Fullstack/dashboard.php";

            echo json_encode([
                "success" => true,
                "message" => "Login successful!",
                "redirect" => $redirectUrl
            ]);
        } else {
            echo json_encode(["success" => false, "message" => "Incorrect password."]);
        }
    } else {
        echo json_encode(["success" => false, "message" => "Email not registered."]);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(["success" => false, "message" => "Invalid request method."]);
}
?>