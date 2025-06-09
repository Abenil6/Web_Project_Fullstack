<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();

include "backend/db.php";

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$success_message = $error_message = "";

// Fetch existing user data
$stmt = $conn->prepare("SELECT first_name, email FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $first_name = trim($_POST['first_name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (!empty($first_name) && !empty($email)) {
        if (!empty($password)) {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("UPDATE users SET first_name=?, email=?, password=? WHERE id=?");
            $stmt->bind_param("sssi", $first_name, $email, $hashed_password, $user_id);
        } else {
            $stmt = $conn->prepare("UPDATE users SET first_name=?, email=? WHERE id=?");
            $stmt->bind_param("ssi", $first_name, $email, $user_id);
        }

        if ($stmt->execute()) {
            $_SESSION['first_name'] = $first_name; // Update session
            $success_message = "Profile updated successfully!";
            // Refresh user data
            $user['first_name'] = $first_name;
            $user['email'] = $email;
        } else {
            $error_message = "Update failed. Please try again.";
        }
    } else {
        $error_message = "Name and email cannot be empty.";
    }
}
?>

<!-- HTML Form -->
<!DOCTYPE html>
<html>

<head>
    <title>My Profile</title>
    <style>
        body {
            font-family: 'Montserrat', sans-serif;
            background: #2B1103;
            color: #DCC69C;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 5rem auto;
            padding: 3rem;
            background: rgba(220, 198, 156, 0.05);
            border: 1px solid rgba(220, 198, 156, 0.3);
            border-radius: 1rem;
        }

        h2 {
            text-align: center;
            font-size: 2.5rem;
            margin-bottom: 2rem;
        }

        form label {
            display: block;
            margin: 1.5rem 0 0.5rem;
            font-size: 1.6rem;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 1rem;
            font-size: 1.6rem;
            border: none;
            border-radius: 0.5rem;
            background: #fff;
            color: #000;
        }

        button {
            display: block;
            width: 100%;
            margin-top: 2rem;
            padding: 1rem;
            background: #DCC69C;
            color: #2B1103;
            font-size: 1.8rem;
            border: none;
            border-radius: 0.5rem;
            cursor: pointer;
        }

        button:hover {
            background: #e4cfa7;
        }

        .message {
            margin-top: 2rem;
            text-align: center;
            font-size: 1.6rem;
        }

        .error {
            color: red;
        }

        .success {
            color: lightgreen;
        }

        a {
            display: block;
            text-align: center;
            margin-top: 2rem;
            font-size: 1.4rem;
            color: #DCC69C;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Edit Profile</h2>

        <?php if ($error_message): ?>
            <p class="message error"><?php echo $error_message; ?></p>
        <?php endif; ?>

        <?php if ($success_message): ?>
            <p class="message success"><?php echo $success_message; ?></p>
        <?php endif; ?>

        <form method="POST">
            <label>First Name:</label>
            <input type="text" name="first_name"
                value="<?php echo htmlspecialchars($user['first_name'] ?? '', ENT_QUOTES); ?>" required>

            <label>Email:</label>
            <input type="email" name="email" value="<?php echo htmlspecialchars($user['email'] ?? '', ENT_QUOTES); ?>"
                required>

            <label>New Password (leave blank to keep current password):</label>
            <input type="password" name="password">

            <button type="submit">Update</button>
        </form>

        <a href="dashboard.php">← Back to Dashboard</a>
    </div>
</body>

</html>