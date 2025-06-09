<?php
session_start();

// Redirect to login if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: index.html");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Dashboard | Sabana Beach Resort</title>
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
            font-family: 'MontserSrat', sans-serif;
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

        /* Dashboard styles */
        .dashboard {
            padding: 3rem 2rem;
        }

        .dashboard .content {
            background: rgba(220, 198, 156, 0.1);
            padding: 3rem;
            border-radius: 1rem;
            border: var(--border);
            margin-top: 2rem;
        }

        .dashboard h1 {
            font-size: 3rem;
            color: var(--sub-color);
            margin-bottom: 1.5rem;
        }

        .dashboard p {
            font-size: 1.8rem;
            color: var(--sub-color);
            line-height: 1.6;
            margin-bottom: 2rem;
        }

        .dashboard-features {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(25rem, 1fr));
            gap: 2rem;
            margin-top: 3rem;
        }

        .feature-card {
            background: rgba(220, 198, 156, 0.1);
            padding: 2rem;
            border-radius: 1rem;
            border: var(--border);
            transition: transform 0.3s ease;
            text-align: center;
        }

        .feature-card:hover {
            transform: translateY(-5px);
        }

        .feature-card i {
            font-size: 3rem;
            color: var(--sub-color);
            margin-bottom: 1.5rem;
        }

        .feature-card h3 {
            font-size: 2rem;
            color: var(--sub-color);
            margin-bottom: 1rem;
        }

        .feature-card p {
            font-size: 1.6rem;
            margin-bottom: 1.5rem;
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
                <a href="logout.php" class="btn">Logout</a>
                <a href="reservation.html" class="btn">Make a Reservation</a>
            </div>
            <div id="menu-btn" class="fas fa-bars"></div>
        </div>
        <nav class="navbar">
            <a href="index.html">Home</a>
            <a href="index.html#about">About</a>
            <a href="index.html#reservation">Reservation</a>
            <a href="gallery.html">Gallery</a>
            <a href="index.html#contact">Contact</a>
            <a href="index.html#reviews">Reviews</a>
            <a href="index.html#pricing">Pricing</a>
        </nav>
    </header>

    <!-- Dashboard Section -->
    <section class="dashboard">
        <div class="content">
            <h1>Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?>!</h1>
            <p>This is your dashboard where you can manage your bookings and profile.</p>

            <div class="dashboard-features">
                <div class="feature-card"> <i class="fas fa-calendar-check"></i>
                    <h3>My Bookings</h3>
                    <p>View and manage your current and past reservations.</p> <a href="booking.php" class="btn">Go to
                        Bookings</a>
                </div>
                <div class="feature-card">
                    <i class="fas fa-user-edit"></i>
                    <h3>Profile Settings</h3>
                    <p>Update your personal information and preferences.</p>
                    <a href="profile.php" class="btn">Manage Profile</a>
                </div>
            </div>
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
        <div class="credit">&copy; 2025 Sabana Beach Resort. All rights reserved.</div>
    </footer>

    <script>
        let menuBtn = document.querySelector('#menu-btn');
        let navbar = document.querySelector('.navbar');

        menuBtn.onclick = () => {
            navbar.classList.toggle('active');
        }
    </script>