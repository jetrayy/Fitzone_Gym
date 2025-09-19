<?php 
session_start();
include('../dbconnect.php'); // Adjust path if needed

// Count records
$userCount = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM users WHERE role='customer'"));
$staffCount = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM users WHERE role='staff'"));
$trainerCount = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM trainers"));
$appointmentCount = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM appointments"));

// Delete staff
if (isset($_GET['delete_staff'])) {
    $id = intval($_GET['delete_staff']);
    mysqli_query($conn, "DELETE FROM users WHERE user_id=$id AND role='staff'");
    header("Location: dashboard.php");
}

// Delete customer
if (isset($_GET['delete_customer'])) {
    $id = intval($_GET['delete_customer']);
    mysqli_query($conn, "DELETE FROM users WHERE user_id=$id AND role='customer'");
    header("Location: dashboard.php");
}

// Register staff
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register_staff'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    mysqli_query($conn, "INSERT INTO users (username, pwd, email, role) VALUES ('$username', '$password', '$email', 'staff')");
    header("Location: dashboard.php");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <link rel="icon" type="image/x-icon" href="image/icons/sicon.ico">

    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #000;
            font-family: Arial, sans-serif;
            color: white;
        }
        .header {
            background-color: #111;
            padding: 20px;
            text-align: center;
            position: relative;
        }
        .header img {
            height: 60px;
            position: absolute;
            left: 30px;
        }
        .header h1 {
            color: #dc3545;
            font-size: 2.5em;
            margin: 0;
            display: inline-block;
        }
        .nav-buttons {
            position: absolute;
            top: 20px;
            right: 30px;
        }
        .nav-buttons a {
            background-color: #dc3545;
            color: white;
            text-decoration: none;
            padding: 8px 14px;
            border-radius: 5px;
            margin-left: 10px;
        }
        .nav-buttons a:hover {
            background-color: darkred;
        }
        .container {
            padding: 20px 40px;
        }
        .stat-box {
            display: inline-block;
            width: 23%;
            background: #222;
            padding: 20px;
            margin: 1%;
            border-radius: 10px;
            text-align: center;
            color: #fff;
        }
        .stat-box h3 {
            margin: 0;
            font-size: 18px;
            color: #dc3545;
        }
        .form-section {
            margin-top: 40px;
        }
        input[type="text"], input[type="email"], input[type="password"] {
            padding: 8px;
            width: 25%;
            margin-right: 10px;
            border-radius: 5px;
            border: none;
        }
        button {
            padding: 8px 14px;
            background-color: #dc3545;
            color: white;
            border: none;
            border-radius: 5px;
        }
        button:hover {
            background-color: darkred;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: #111;
        }
        table th, table td {
            padding: 10px;
            border: 1px solid #444;
            color: white;
        }
        table th {
            background-color: #dc3545;
        }
        .btn-delete {
            background-color: crimson;
            color: white;
            padding: 5px 10px;
            text-decoration: none;
            border-radius: 5px;
        }
        .btn-delete:hover {
            background-color: darkred;
        }
    </style>
</head>
<body>

<div class="header">
    <img src="../image/logo.png" alt="FitZone Logo">
    <h1>Admin Dashboard</h1>
    <div class="nav-buttons">
        <a href="managetrainers.php">Manage Trainers</a>
        <a href="../../includes/logout.php">Logout</a>
    </div>
</div>

<div class="container">
    <div class="stat-box">
        <h3>Customers</h3>
        <p><?= $userCount ?></p>
    </div>
    <div class="stat-box">
        <h3>Staff</h3>
        <p><?= $staffCount ?></p>
    </div>
    <div class="stat-box">
        <h3>Trainers</h3>
        <p><?= $trainerCount ?></p>
    </div>
    <div class="stat-box">
        <h3>Appointments</h3>
        <p><?= $appointmentCount ?></p>
    </div>

    <div class="form-section">
        <h2>Register New Staff</h2>
        <form method="POST">
            <input type="text" name="username" placeholder="Username" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit" name="register_staff">Register Staff</button>
        </form>
    </div>

    <div class="form-section">
        <h2>Manage Staff Members</h2>
        <table>
            <tr><th>ID</th><th>Username</th><th>Email</th><th>Action</th></tr>
            <?php
            $staffs = mysqli_query($conn, "SELECT * FROM users WHERE role='staff'");
            while ($staff = mysqli_fetch_assoc($staffs)) {
                echo "<tr>
                        <td>{$staff['user_id']}</td>
                        <td>{$staff['username']}</td>
                        <td>{$staff['email']}</td>
                        <td><a href='dashboard.php?delete_staff={$staff['user_id']}' class='btn-delete'>Delete</a></td>
                    </tr>";
            }
            ?>
        </table>
    </div>

    <div class="form-section">
        <h2>Manage Customers</h2>
        <table>
            <tr><th>ID</th><th>Username</th><th>Email</th><th>Action</th></tr>
            <?php
            $customers = mysqli_query($conn, "SELECT * FROM users WHERE role='customer'");
            while ($cust = mysqli_fetch_assoc($customers)) {
                echo "<tr>
                        <td>{$cust['user_id']}</td>
                        <td>{$cust['username']}</td>
                        <td>{$cust['email']}</td>
                        <td><a href='dashboard.php?delete_customer={$cust['user_id']}' class='btn-delete'>Delete</a></td>
                    </tr>";
            }
            ?>
        </table>
    </div>
</div>

</body>
</html>
