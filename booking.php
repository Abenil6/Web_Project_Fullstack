<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


session_start();

if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('Please login first.'); window.location.href = '../login.html';</script>";
    exit;
}

include "backend/db.php";

$user_id = $_SESSION['user_id'];

$sql = "SELECT * FROM reservations WHERE user_id = ? ORDER BY created_at DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>

<head>
    <title>My Bookings</title>
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
            scroll-behavior: smooth;
            scroll-padding-top: 2rem;
            overflow-x: hidden;
        }

        body {
            background-color: var(--main-color);
            color: var(--sub-color);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Header */
        .header {
            padding: 1rem 2rem;
            max-width: 1200px;
            margin: 0 auto;
            width: 100%;
        }

        .header .flex {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1.5rem;
        }

        .header .flex .logo {
            color: var(--sub-color);
            font-size: 2.5rem;
            font-weight: 700;
        }

        .header .flex .btn {
            cursor: pointer;
            padding: 1rem 3rem;
            border: var(--border);
            font-size: 1.8rem;
            color: var(--sub-color);
            background-color: var(--main-color);
            text-align: center;
            text-transform: capitalize;
            transition: .2s linear;
            margin-top: 0;
        }

        .header .flex .btn:hover {
            border-radius: 5rem;
            background-color: var(--sub-color);
            color: var(--main-color);
        }

        .header .flex #menu-btn {
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
            padding: .5rem;
            border-radius: .5rem;
            max-width: 1200px;
            margin-left: auto;
            margin-right: auto;
        }

        .header .navbar a {
            font-size: 1.8rem;
            color: var(--main-color);
            padding: 1rem 3rem;
            border-radius: .5rem;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .header .navbar a:hover {
            background-color: var(--main-color);
            color: var(--sub-color);
        }

        /* Main section */
        section.bookings-section {
            max-width: 1200px;
            width: 100%;
            margin: 3rem auto;
            padding: 2rem;
            background: rgba(220, 198, 156, 0.1);
            border-radius: 1rem;
            border: var(--border);
            flex-grow: 1;
        }

        section.bookings-section h1 {
            font-size: 3rem;
            margin-bottom: 2rem;
            color: var(--sub-color);
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 1.6rem;
            background-color: rgba(220, 198, 156, 0.05);
            border-radius: 0.5rem;
            overflow: hidden;
        }

        thead tr {
            background-color: var(--sub-color);
            color: var(--main-color);
        }

        th,
        td {
            padding: 1.2rem 1.5rem;
            border-bottom: var(--border);
            text-align: center;
        }

        tbody tr:hover {
            background-color: rgba(220, 198, 156, 0.2);
            cursor: default;
        }

        tbody tr:last-child td {
            border-bottom: none;
        }

        /* Responsive */
        @media (max-width: 768px) {
            html {
                font-size: 55%;
            }

            .header .flex #menu-btn {
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

            table,
            thead,
            tbody,
            th,
            td,
            tr {
                display: block;
                width: 100%;
            }

            thead tr {
                position: absolute;
                top: -9999px;
                left: -9999px;
            }

            tbody tr {
                margin-bottom: 1.5rem;
                border: var(--border);
                border-radius: 1rem;
                padding: 1rem;
                background: rgba(220, 198, 156, 0.1);
            }

            tbody td {
                text-align: right;
                padding-left: 50%;
                position: relative;
            }

            tbody td::before {
                content: attr(data-label);
                position: absolute;
                left: 1rem;
                top: 1rem;
                font-weight: 600;
                color: var(--sub-color);
                text-transform: capitalize;
            }
        }

        /* Footer */
        .footer {
            background-color: var(--main-color);
            padding: 3rem 9%;
            border-top: var(--border);
            margin-top: auto;
        }

        .footer .box-container {
            display: flex;
            flex-wrap: wrap;
            gap: 1.5rem;
            justify-content: space-between;
            max-width: 1200px;
            margin: 0 auto;
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
    </style>
</head>

<body>
    <h1>My Bookings</h1><br>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Check-In</th>
                <th>Check-Out</th>
                <th>Adults</th>
                <th>Children</th>
                <th>Rooms</th>
                <th>Booked On</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $count = 1;
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>{$count}</td>
                            <td>{$row['check_in']}</td>
                            <td>{$row['check_out']}</td>
                            <td>{$row['adults']}</td>
                            <td>{$row['childs']}</td>
                            <td>{$row['rooms']}</td>
                            <td>{$row['created_at']}</td>
                          </tr>";
                    $count++;
                }
            } else {
                echo "<tr><td colspan='7'>No bookings found.</td></tr>";
            }

            $stmt->close();
            $conn->close();
            ?>
        </tbody>
    </table>
</body>

</html>