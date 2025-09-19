<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
include('../dbconnect.php');

// Get today's and week's stats
$today = date('Y-m-d');
$appt_today = mysqli_query($conn, "SELECT COUNT(*) AS total FROM appointments WHERE appointment_date = '$today'");
if (!$appt_today) {
    die('Error fetching today\'s appointments: ' . mysqli_error($conn));
}
$today_total = mysqli_fetch_assoc($appt_today)['total'];

$week_start = date('Y-m-d', strtotime('monday this week'));
$week_end = date('Y-m-d', strtotime('sunday this week'));
$appt_week = mysqli_query($conn, "SELECT COUNT(*) AS total FROM appointments WHERE appointment_date BETWEEN '$week_start' AND '$week_end'");
if (!$appt_week) {
    die('Error fetching week\'s appointments: ' . mysqli_error($conn));
}
$week_total = mysqli_fetch_assoc($appt_week)['total'];

// Placeholder for new user count, remove if `created_at` doesn't exist
$new_users = 'N/A'; // Placeholder for display

// Fetch pending appointments
$pending_appts = mysqli_query($conn, "SELECT * FROM appointments WHERE status = 'pending'");
if (!$pending_appts) {
    die('Error fetching pending appointments: ' . mysqli_error($conn));
}

// Fetch responded appointments (updated or cancelled appointments)
$responded_appts = mysqli_query($conn, "SELECT * FROM appointments WHERE status != 'pending'");
if (!$responded_appts) {
    die('Error fetching responded appointments: ' . mysqli_error($conn));
}

// Approve/cancel appointments
if (isset($_GET['approve'])) {
    $id = $_GET['approve'];
    mysqli_query($conn, "UPDATE appointments SET status = 'confirmed' WHERE id = '$id'");
    header("Location: staff_page.php");
    exit;
}

if (isset($_GET['cancel'])) {
    $id = $_GET['cancel'];
    mysqli_query($conn, "UPDATE appointments SET status = 'cancelled' WHERE id = '$id'");
    header("Location: staff_page.php");
    exit;
}

// Fetch queries
$queries = mysqli_query($conn, "SELECT * FROM queries");
if (isset($_POST['reply'])) {
    $query_id = $_POST['query_id'];
    $reply = $_POST['reply_text'];
    mysqli_query($conn, "UPDATE queries SET reply = '$reply', status = 'replied' WHERE query_id = '$query_id'");
    header("Location: staff_page.php");
    exit;
}

// Logout functionality
if (isset($_GET['logout'])) {
    session_unset();
    session_destroy();
    header("Location: ../index.php");  // Redirect to home page after logout
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Staff Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 30px;
            background-color: #000;
            color: #fff;
        }
        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px;
            background-color: #000;
        }
        header h1 {
            color: #e63946; /* Red color for Staff Dashboard */
            font-size: 2.5em;
            margin: 0;
        }
        h2 {
            color: #fff;
        }
        /* Overview Cards */
        .overview {
            display: flex;
            justify-content: space-between;
            margin-top: 30px;
        }
        .overview .card {
            background-color: #444;
            color: #fff;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            width: 30%;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
        }
        .overview .card h3 {
            margin: 10px 0;
            font-size: 1.5em;
        }
        .overview .card p {
            font-size: 1.2em;
            font-weight: bold;
        }
        /* Table Styles */
        table {
            border-collapse: collapse;
            width: 100%;
            margin-bottom: 30px;
        }
        th, td {
            padding: 10px;
            border: 1px solid #bbb;
            text-align: center;
        }
        th {
            background-color: #e63946; /* Red color */
            color: #fff;
        }
        tr:nth-child(even) {
            background-color: #222;
        }
        .status-confirmed {
            color: green;
            font-weight: bold;
        }
        .status-cancelled {
            color: red;
            font-weight: bold;
        }
        button, a.button {
            padding: 5px 10px;
            background: #e63946; /* Red background */
            color: white;
            text-decoration: none;
            border: none;
            border-radius: 4px;
            margin: 2px;
            cursor: pointer;
        }
        a.button.cancel {
            background: #dc3545; /* Dark red for cancel */
        }
        button:hover, a.button:hover {
            opacity: 0.8;
        }
        form {
            display: inline-block;
        }
        input[type="text"], input[type="file"] {
            margin: 10px 5px;
            padding: 6px;
        }
        .back-button, .logout-button {
            background-color: #333;
        }
        .nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<header>
    <div class="logo">
        <img src="../image/logo.png" alt="FitZone Logo" style="width: 100px; height: auto;">
    </div>
    <h1>Staff Dashboard</h1>
    <div>
        <!-- Go Back Button with JavaScript for browser navigation -->
        <!-- Updated Logout Button with Correct File Path -->
        <a href="../logout.php" class="button logout-button">Logout</a> <!-- Logout button -->
        <a href="announcement.php" class="button">Announcements</a> <!-- Link to announcements page -->
        <a href="vquery.php" class="button">View Queries</a> <!-- View Queries Button inside the header -->
    </div>
</header>

<h2>Overview</h2>

<!-- Overview Section with Cards -->
<div class="overview">
    <div class="card">
        <h3>Total Appointments Today</h3>
        <p><?php echo $today_total; ?></p>
    </div>

    <div class="card">
        <h3>Total Appointments This Week</h3>
        <p><?php echo $week_total; ?></p>
    </div>

    <div class="card">
        <h3>New Registrations This Week</h3>
        <p><?php echo $new_users; ?></p>
    </div>
</div>

<h2>Pending Appointments</h2>
<table>
    <tr>
        <th>ID</th>
        <th>User</th>
        <th>Date</th>
        <th>Time</th>
        <th>Status</th>
        <th>Action</th>
    </tr>
    <?php while ($row = mysqli_fetch_assoc($pending_appts)): ?>
    <tr>
        <td><?= $row['id'] ?></td>
        <td><?= $row['user_id'] ?></td>
        <td><?= $row['appointment_date'] ?></td>
        <td><?= $row['appointment_time'] ?></td>
        <td><?= ucfirst($row['status']) ?></td>
        <td>
            <a href="?approve=<?= $row['id'] ?>" class="button">Confirm</a>
            <a href="?cancel=<?= $row['id'] ?>" class="button cancel" onclick="return confirm('Are you sure you want to cancel this appointment?')">Cancel</a>
        </td>
    </tr>
    <?php endwhile; ?>
</table>

<h2>Responded Appointments</h2>
<table>
    <tr>
        <th>ID</th>
        <th>User</th>
        <th>Date</th>
        <th>Time</th>
        <th>Status</th>
    </tr>
    <?php while ($row = mysqli_fetch_assoc($responded_appts)): ?>
    <tr>
        <td><?= $row['id'] ?></td>
        <td><?= $row['user_id'] ?></td>
        <td><?= $row['appointment_date'] ?></td>
        <td><?= $row['appointment_time'] ?></td>
        <td class="status-<?= strtolower($row['status']) ?>"><?= ucfirst($row['status']) ?></td>
    </tr>
    <?php endwhile; ?>
</table>

</body>
</html>
