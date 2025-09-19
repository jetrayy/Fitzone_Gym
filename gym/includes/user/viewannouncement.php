<?php
session_start();
include('../dbconnect.php');

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php"); // Redirect to login if not logged in
    exit();
}

// Fetch all announcements from the database
$announcements = mysqli_query($conn, "SELECT * FROM announcements ORDER BY uploaded_on DESC");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Announcements - FitZone</title>
    <link rel="icon" type="image/x-icon" href="../image/icons/sicon.ico">
    <style>
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

        .announcement-box {
            background: #222;
            padding: 20px;
            margin: 20px 0;
            border-radius: 10px;
            text-align: center;
        }

        .announcement-box h3 {
            margin: 10px 0;
            font-size: 1.5em;
        }

        .announcement-box p {
            line-height: 1.6;
        }

        .download-btn {
            display: inline-block;
            margin-top: 20px;
            padding: 12px 24px;
            background: red;
            color: white;
            font-weight: bold;
            border-radius: 5px;
            text-decoration: none;
            transition: background 0.3s;
        }

        .download-btn:hover {
            background: #c70000;
        }

        .back-btn {
            margin-top: 20px;
            background-color: #333;
            padding: 10px 20px;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }

        .back-btn:hover {
            background-color: #444;
        }
    </style>
</head>
<body>

<header>
    <div class="logo">
        <img src="../image/logo.png" alt="FitZone Logo">
    </div>
    <h1>View Announcements</h1>
    <div class="nav-links">
        <a href="user_dashboard.php">Go Back</a>
        <a href="../logout.php">Logout</a>
    </div>
</header>

<div class="container">
    <h2 class="section-title">Announcements</h2>

    <?php while ($row = mysqli_fetch_assoc($announcements)): ?>
    <div class="announcement-box">
        <h3>Announcement: <?= $row['note'] ?></h3>
        <p>Uploaded on: <?= $row['uploaded_on'] ?></p>
        <?php if ($row['file_name']): ?>
            <a href="../uploads/<?= $row['file_name'] ?>" class="download-btn" target="_blank">Download File</a>
        <?php else: ?>
            <p>No file attached.</p>
        <?php endif; ?>
    </div>
    <?php endwhile; ?>

    <a href="user_dashboard.php" class="back-btn">Back to Dashboard</a>
</div>

</body>
</html>
