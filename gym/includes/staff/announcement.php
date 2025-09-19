<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
include('../dbconnect.php');

// Check if the user is logged in as staff
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'staff') {
    header("Location: ../login.php"); // Redirect to login if not logged in
    exit();
}

// Handle adding a new announcement
if (isset($_POST['add_announcement'])) {
    $note = mysqli_real_escape_string($conn, $_POST['note']);
    $filename = '';

    // Check if a file is uploaded and handle file upload
    if (!empty($_FILES['announcement_image']['name'])) {
        $filename = basename($_FILES['announcement_image']['name']);
        $uploadDir = "../uploads/";
        $filePath = $uploadDir . $filename;

        // Check if the file is uploaded correctly
        if (move_uploaded_file($_FILES['announcement_image']['tmp_name'], $filePath)) {
            // Insert announcement into the database with the file path and timestamp
            $insertQuery = "INSERT INTO announcements (staff_id, note, file_name, uploaded_on) VALUES ('{$_SESSION['user_id']}', '$note', '$filename', NOW())";
            if (mysqli_query($conn, $insertQuery)) {
                header("Location: announcement.php"); // Redirect after successful insert
                exit();
            } else {
                echo "Error: " . $insertQuery . "<br>" . mysqli_error($conn);
            }
        } else {
            echo "<p class='error-msg'>Error uploading file. Please try again.</p>";
        }
    } else {
        // Insert announcement without file if no file is provided
        $insertQuery = "INSERT INTO announcements (staff_id, note, file_name, uploaded_on) VALUES ('{$_SESSION['user_id']}', '$note', '', NOW())";
        if (mysqli_query($conn, $insertQuery)) {
            header("Location: announcement.php"); // Redirect after successful insert
            exit();
        } else {
            echo "Error: " . $insertQuery . "<br>" . mysqli_error($conn);
        }
    }
}

// Fetch all announcements from the database
$announcements = mysqli_query($conn, "SELECT * FROM announcements ORDER BY uploaded_on DESC");

// Handle announcement deletion
if (isset($_GET['delete'])) {
    $announcement_id = $_GET['delete'];
    // Delete the announcement from the database
    mysqli_query($conn, "DELETE FROM announcements WHERE announcement_id = $announcement_id");
    header("Location: announcement.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Announcements - Staff Dashboard</title>
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
        input[type="text"], input[type="file"], textarea {
            margin: 10px 5px;
            padding: 6px;
        }
        .back-button, .logout-button {
            background-color: #333;
        }
    </style>
</head>
<body>

<header>
    <div class="logo">
        <img src="../image/logo.png" alt="FitZone Logo" style="width: 100px; height: auto;">
    </div>
    <h1>Announcements</h1>
    <div>
        <a href="../logout.php" class="button logout-button">Logout</a> <!-- Logout button -->
        <a href="staff_page.php" class="button">Staff Dashboard</a> <!-- Link to the Staff Dashboard -->
    </div>
</header>

<h2>Add Announcement</h2>
<form method="POST" enctype="multipart/form-data">
    <textarea name="note" placeholder="Enter your announcement here..." required rows="4" cols="50"></textarea><br>
    <input type="file" name="announcement_image"><br><br>
    <button type="submit" name="add_announcement">Add Announcement</button>
</form>

<hr>

<h2>View Announcements</h2>
<table>
    <tr>
        <th>Announcement</th>
        <th>File</th>
        <th>Uploaded On</th>
        <th>Action</th>
    </tr>
    <?php while ($row = mysqli_fetch_assoc($announcements)): ?>
    <tr>
        <td><?= $row['note'] ?></td>
        <td>
            <?php if ($row['file_name']): ?>
                <a href="../uploads/<?= $row['file_name'] ?>" target="_blank">Download</a>
            <?php else: ?>
                No File
            <?php endif; ?>
        </td>
        <td><?= $row['uploaded_on'] ?></td>
        <td>
            <a href="?delete=<?= $row['announcement_id'] ?>" class="button cancel" onclick="return confirm('Are you sure you want to delete this announcement?')">Delete</a>
        </td>
    </tr>
    <?php endwhile; ?>
</table>

</body>
</html>
