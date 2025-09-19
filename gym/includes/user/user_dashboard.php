<?php 
// Start the session
session_start();
include('../dbconnect.php');

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

// Fetch user details from the database
$user_id = $_SESSION['user_id'];
$query = mysqli_query($conn, "SELECT * FROM users WHERE user_id = $user_id");
$user = mysqli_fetch_assoc($query);

// Fetch user appointments
$appointments = mysqli_query($conn, "SELECT * FROM appointments WHERE user_id = $user_id");

// Fetch user queries
$queries = mysqli_query($conn, "SELECT * FROM queries WHERE user_id = $user_id");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard - FitZone</title>
    <link rel="icon" type="image/x-icon" href="../image/icons/sicon.ico">
    <style>
        /* Basic styling */
        body {
            font-family: Arial, sans-serif;
            background-color: #111;
            color: white;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: black;
            color: white;
            padding: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        header img {
            height: 50px;
        }

        header h1 {
            color: red;
            font-size: 2.5em;
        }

        .nav-links a {
            color: white;
            padding: 10px;
            text-decoration: none;
            background-color: red;
            border-radius: 5px;
            margin-left: 10px;
        }

        .nav-links a:hover {
            background-color: darkred;
        }

        .container {
            padding: 20px;
        }

        .section-title {
            font-size: 1.8em;
            margin-bottom: 20px;
            color: red;
        }

        .dashboard-box {
            background: #222;
            padding: 20px;
            margin: 20px 0;
            border-radius: 10px;
            text-align: center;
        }

        .dashboard-box h3 {
            margin: 10px 0;
            font-size: 1.5em;
        }

        .appointments, .queries {
            margin-top: 40px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #222;
        }

        th, td {
            padding: 12px;
            text-align: center;
            border: 1px solid #444;
        }

        th {
            background-color: red;
            color: white;
        }

        td {
            color: white;
        }

        .btn {
            background-color: red;
            color: white;
            padding: 5px 10px;
            border-radius: 5px;
            text-decoration: none;
        }

        .btn:hover {
            background-color: darkred;
        }
    </style>
</head>
<body>

<header>
    <div class="logo">
        <img src="../image/logo.png" alt="FitZone Logo">
    </div>
    <h1>User Dashboard</h1>
    <div class="nav-links">
        <a href="../user/membership.php">Membership</a>
        <a href="../appointment.php">Appointment</a>
        <a href="../user/viewannouncement.php">Announcements</a>
        <a href="../user/query.php">Query</a>
        <a href="../logout.php">Logout</a>
    </div>
</header>

<div class="container">
    <!-- User Info Section -->
    <div class="dashboard-box">
        <h3>Welcome, <?= $user['username']; ?></h3>
        <p>Your membership type: <?= $user['membership_plan']; ?></p>
    </div>

    <!-- Appointments Section -->
    <div class="appointments">
        <h2 class="section-title">Your Appointments</h2>
        <table>
            <tr>
                <th>Appointment ID</th>
                <th>Date</th>
                <th>Time</th>
                <th>Status</th>
            </tr>
            <?php while ($appointment = mysqli_fetch_assoc($appointments)): ?>
            <tr>
                <td><?= $appointment['id']; ?></td>
                <td><?= $appointment['appointment_date']; ?></td>
                <td><?= $appointment['appointment_time']; ?></td>
                <td><?= $appointment['status']; ?></td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>

    <!-- Queries Section -->
    <div class="queries">
        <h2 class="section-title">Your Queries</h2>
        <table>
            <tr>
                <th>Query ID</th>
                <th>Subject</th>
                <th>Message</th>
                <th>Reply</th>
            </tr>
            <?php while ($query = mysqli_fetch_assoc($queries)): ?>
            <tr>
                <td><?= $query['query_id']; ?></td>
                <td><?= $query['subject']; ?></td>
                <td><?= $query['message']; ?></td>
                <td><?= $query['reply'] ? $query['reply'] : 'No reply yet'; ?></td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>
</div>

</body>
</html>
