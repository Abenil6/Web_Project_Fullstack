<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.html");
    exit;
}

include '../backend/db.php';

$sql = "SELECT * FROM messages ORDER BY id DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Admin - Feedbacks | Sabana Beach Resort</title>
    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap');

        :root {
            --main-color: #2B1103;
            --sub-color: #DCC69C;
            --white: #fff;
            --border: .1rem solid rgba(220, 198, 156, .3);
        }

        * {
            font-family: 'Montserrat', sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            outline: none;
            border: none;
            text-decoration: none;
        }

        *::selection {
            background-color: var(--sub-color);
            color: var(--main-color);
        }

        html {
            font-size: 62.5%;
            overflow-x: hidden;
            scroll-behavior: smooth;
            scroll-padding-top: 2rem;
        }

        body {
            background-color: var(--main-color);
            color: var(--sub-color);
        }

        section {
            padding: 3rem 2rem;
            max-width: 1200px;
            margin: 0 auto;
        }

        .btn {
            display: inline-block;
            cursor: pointer;
            padding: 1rem 3rem;
            border: var(--border);
            font-size: 1.8rem;
            color: var(--sub-color);
            text-align: center;
            text-transform: capitalize;
            transition: 0.2s linear;
            margin-top: 1rem;
            background-color: var(--main-color);
            border-radius: 0.5rem;
        }

        .btn:hover {
            background-color: var(--sub-color);
            color: var(--main-color);
            border-radius: 5rem;
        }

        /* Header styles */
        .header {
            padding-bottom: 0;
            max-width: 1200px;
            width: 100%;
            margin: 0 auto;
            padding: 0 2rem;
        }

        .header .flex {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1.5rem;
            max-width: 1200px;
            margin: 0 auto;
        }

        .header .flex .logo {
            color: var(--sub-color);
            font-size: 2.5rem;
            font-weight: 700;
        }

        .header .flex .btn {
            margin-top: 0;
        }

        .header .flex .fa-bars {
            font-size: 3rem;
            cursor: pointer;
            color: var(--sub-color);
            display: none;
        }

        .header .navbar {
            display: flex;
            align-items: center;
            justify-content: space-evenly;
            gap: 1.5rem;
            margin-top: 2rem;
            background-color: var(--sub-color);
            padding: 0.5rem;
            border-radius: 0.5rem;
            max-width: 1200px;
            margin-left: auto;
            margin-right: auto;
        }

        .header .navbar a {
            font-size: 1.8rem;
            color: var(--main-color);
            padding: 1rem 3rem;
            border-radius: 0.5rem;
            transition: background-color 0.3s ease;
        }

        .header .navbar a:hover {
            background-color: var(--main-color);
            color: var(--sub-color);
        }

        /* Feedback styles */
        .feedback {
            padding: 3rem 2rem;
        }

        .feedback .content {
            background: rgba(220, 198, 156, 0.1);
            padding: 3rem;
            border-radius: 1rem;
            border: var(--border);
            margin-top: 2rem;
        }

        .feedback h1 {
            font-size: 3rem;
            color: var(--sub-color);
            margin-bottom: 1.5rem;
            text-align: center;
        }

        .feedback .back {
            display: inline-block;
            font-size: 1.8rem;
            color: var(--sub-color);
            margin-bottom: 2rem;
            transition: color 0.3s ease;
        }

        .feedback .back:hover {
            color: var(--white);
        }

        .feedback .back i {
            margin-right: 0.5rem;
        }

        .feedback table {
            width: 100%;
            border-collapse: collapse;
            background: rgba(220, 198, 156, 0.1);
            border: var(--border);
            border-radius: 0.5rem;
            overflow: hidden;
        }

        .feedback th,
        .feedback td {
            padding: 1.5rem;
            border-bottom: var(--border);
            text-align: center;
            font-size: 1.6rem;
        }

        .feedback th {
            background-color: var(--sub-color);
            color: var(--main-color);
            font-weight: 600;
        }

        .feedback tr:hover {
            background-color: rgba(220, 198, 156, 0.2);
        }

        .feedback td {
            color: var(--sub-color);
        }

        /* Footer styles */
        .footer {
            background-color: var(--main-color);
            padding: 3rem 9%;
            border-top: var(--border);
            margin-top: 4rem;
        }

        .footer .box-container {
            display: flex;
            flex-wrap: wrap;
            gap: 1.5rem;
            justify-content: space-between;
        }

        .footer .box {
            flex: 1 1 25rem;
        }

        .footer .box a {
            display: block;
            font-size: 1.8rem;
            color: var(--sub-color);
            padding: 1rem 0;
            transition: color 0.3s ease;
        }

        .footer .box a:hover {
            color: var(--white);
        }

        .footer .box i {
            margin-right: 1rem;
        }

        .footer .box:nth-child(2) {
            text-align: center;
        }

        .footer .box:last-child {
            text-align: right;
        }

        .footer .box:last-child i {
            margin-left: 1rem;
            margin-right: 0;
        }

        .footer .credit {
            margin-top: 2rem;
            padding: 2rem;
            text-align: center;
            font-size: 2rem;
            color: var(--main-color);
            background-color: var(--sub-color);
            border-radius: 0.5rem;
        }

        /* Responsive styles */
        @media (max-width: 991px) {
            html {
                font-size: 55%;
            }

            .header .flex .fa-bars {
                display: inline-block;
            }

            .header .flex .btn {
                display: none;
            }

            .header .navbar {
                flex-flow: column;
                padding: 2rem;
                display: none;
            }

            .header .navbar.active {
                display: flex;
            }

            .feedback table {
                font-size: 1.4rem;
            }
        }

        @media (max-width: 768px) {
            .footer .box {
                flex: 1 1 100%;
                text-align: center !important;
                margin-bottom: 2rem;
            }

            .footer .box:last-child {
                margin-bottom: 0;
            }

            .feedback table {
                display: block;
                overflow-x: auto;
            }
        }

        @media (max-width: 450px) {
            html {
                font-size: 50%;
            }

            .header .flex .logo {
                font-size: 2rem;
            }
        }
    </style>
</head>

<body>
    <!-- Header Section -->
    <header class="header">
        <div class="flex">
            <a href="index.html" class="logo">Sabana Beach Resort</a>
            <div class="auth-buttons">
                <a href="../logout.php" class="btn">Logout</a>
                <a href="reservation.html" class="btn">Make a Reservation</a>
            </div>
            <div id="menu-btn" class="fas fa-bars"></div>
        </div>
        <nav class="navbar">
            <a href="../index.html">Home</a>
            <a href="../index.html#about">About</a>
            <a href="../index.html#reservation">Reservation</a>
            <a href="../gallery.html">Gallery</a>
            <a href="../index.html#contact">Contact</a>
            <a href="../index.html#reviews">Reviews</a>
            <a href="../index.html#pricing">Pricing</a>
        </nav>
    </header>

    <!-- Feedback Section -->
    <section class="feedback">
        <div class="content">
            <a href="dashboard.php" class="back"><i class="fas fa-arrow-left"></i>Back to Dashboard</a>
            <h1>All Feedback Messages</h1>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Message</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result && $result->num_rows > 0): ?>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?= htmlspecialchars($row['id']) ?></td>
                                <td><?= htmlspecialchars($row['name']) ?></td>
                                <td><?= htmlspecialchars($row['email']) ?></td>
                                <td><?= htmlspecialchars($row['phone']) ?></td>
                                <td><?= htmlspecialchars($row['message']) ?></td>
                                <td><?= htmlspecialchars($row['created_at']) ?></td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6">No messages found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </section>

    <!-- Footer Section -->
    <footer class="footer">
        <div class="box-container">
            <div class="box">
                <a href="#"><i class="fas fa-phone"></i> +251-987-654-321</a>
                <a href="#"><i class="fas fa-envelope"></i> info@sabanabeach.com</a>
                <a href="#"><i class="fas fa-map-marker-alt"></i> Sabana Resort, Ethiopia</a>
            </div>
            <div class="box">
                <a href="#">Home</a>
                <a href="#">About</a>
                <a href="#">Reservation</a>
                <a href="#">Gallery</a>
            </div>
            <div class="box">
                <a href="#"><i class="fab fa-facebook-f"></i></a>
                <a href="#"><i class="fab fa-twitter"></i></a>
                <a href="#"><i class="fab fa-instagram"></i></a>
                <a href="#"><i class="fab fa-tripadvisor"></i></a>
            </div>
        </div>
        <div class="credit">© 2025 Sabana Beach Resort. All rights reserved.</div>
    </footer>

    <script>
        let menuBtn = document.querySelector('#menu-btn');
        let navbar = document.querySelector('.navbar');

        menuBtn.onclick = () => {
            navbar.classList.toggle('active');
        }
    </script>

</body>

</html>

<?php $conn->close(); ?>