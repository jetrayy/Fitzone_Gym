<?php 
session_start();
include('dbconnect.php');
error_reporting(0);

// Check if the user is already logged in
if (isset($_SESSION['user_id'])) {
    header("Location: user/user_dashboard.php"); // Redirect to user dashboard if already logged in
    exit();
}

if (isset($_POST["login"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];
    $user_type = $_POST["user_type"];

    // Prepare and execute query to fetch user by username
    $sql = "SELECT * FROM users WHERE username=? AND role=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $username, $user_type);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if ($row && password_verify($password, $row['pwd'])) {
        $_SESSION['user_id'] = $row['user_id'];     
        $_SESSION['username'] = $row['username']; 
        $_SESSION['role'] = $row['role'];

        // Redirect to correct dashboard based on role
        if ($row['role'] == 'admin') {
            echo '<script>alert("Login successful!"); window.location.href = "admin/dashboard.php";</script>';
        } elseif ($row['role'] == 'staff') {
            echo '<script>alert("Login successful!"); window.location.href = "staff/staff_page.php";</script>';
        } elseif ($row['role'] == 'customer') {
            echo '<script>alert("Login successful!"); window.location.href = "user/user_dashboard.php";</script>';
        }
    } else {
        echo "<p class='error-msg'>Invalid username, password, or user role.</p>";
    }

    $stmt->close();
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin & Staff Login</title>
    <link rel="icon" type="image/x-icon" href="image/icons/sicon.ico">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        * {
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background: url('image/bg-image2.png') no-repeat center center/cover;
            margin: 0;
            padding: 0;
            color: #fff;
            min-height: 100vh;
            background-color: black;
        }

        header {
            background-color:black;
            color: #fff;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
        }

        .logo {
            width: 120px;
        }

        .nav-links {
            list-style: none;
            display: flex;
            gap: 30px;
        }

        .nav-links li a {
            text-decoration: none;
            color: #fff;
            font-weight: 600;
            transition: 0.3s;
        }

        .nav-links li a:hover,
        .nav-links li a.active {
            color: #e63946;
        }

        .login-container {
            margin-top: 130px;
            max-width: 450px;
            background-color: rgba(0, 0, 0, 0.8);
            padding: 40px;
            border-radius: 15px;
            margin-left: auto;
            margin-right: auto;
            box-shadow: 0 8px 20px rgba(255, 255, 255, 0.5);
        }

        .login-container h2 {
            text-align: center;
            color: #e63946;
            margin-bottom: 25px;
        }

        .login-container label {
            display: block;
            margin: 15px 0 5px;
            font-weight: bold;
        }

        .login-container input,
        .login-container select {
            width: 100%;
            padding: 12px;
            border-radius: 8px;
            border: none;
            font-size: 16px;
        }

        .login-container button {
            width: 100%;
            padding: 12px;
            margin-top: 25px;
            background-color: #e63946;
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .login-container button:hover {
            background-color: #d62828;
        }

        .login-container p {
            text-align: center;
            margin-top: 20px;
        }

        .login-container a {
            color: #e63946;
            text-decoration: none;
        }

        .login-container a:hover {
            text-decoration: underline;
        }

        .error-msg {
            text-align: center;
            margin-top: 15px;
            color: #ff4d4d;
        }
    </style>
</head>
<body>

<header>
    <img src="image/logo.png" alt="FitZone Logo" class="logo">
    <ul class="nav-links">
        <li><a href="../index.php">Home</a></li>
        <li><a href="about.php">About</a></li>
        <li><a class="active" href="login.php">Login</a></li>
        <li><a href="membership.php">Membership</a></li>
        
        <li><a href="contact.php">Contact</a></li>
    </ul>
</header>

<div class="login-container">
    <h2>Admin & Staff Login</h2>
    <form action="" method="POST">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>

        <label for="user_type">Login As:</label>
        <select name="user_type" id="user_type" required>
            <option value="">--Select Role--</option>
            <option value="admin">Admin</option>
            <option value="staff">Staff</option>
        </select>

        <button type="submit" name="login">Login</button>
    </form>

    <p><a href="../index.php">Back to Home</a></p>
    <p>User? <a href="login.php">User Login here</a></p>
</div>

</body>
</html>
