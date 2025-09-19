<?php
session_start();
session_regenerate_id(true);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register - FitZone</title>
    <link rel="icon" type="image/x-icon" href="image/icons/sicon.ico">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background: url('image/bg-image2.png') no-repeat center center/cover;
            color: #fff;
            min-height: 100vh;
            overflow-x: hidden;
            background-color: #000;
        }

        header {
            width: 100%;
            background-color: #000;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: fixed;
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

        .register-container {
            margin-top: 130px;
            max-width: 500px;
            background-color: rgba(0, 0, 0, 0.75);
            padding: 40px;
            border-radius: 15px;
            margin-left: auto;
            margin-right: auto;
            box-shadow: 0 8px 20px rgba(142, 140, 140, 0.6);
        }

        .register-container h3 {
            text-align: center;
            margin-bottom: 30px;
            font-size: 30px;
            color: #e63946;
        }

        .register-container label {
            display: block;
            margin-top: 15px;
            font-weight: bold;
        }

        .register-container input[type="text"],
        .register-container input[type="email"],
        .register-container input[type="password"] {
            width: 100%;
            padding: 12px;
            margin-top: 8px;
            border: none;
            border-radius: 8px;
            background-color: #f1f1f1;
            font-size: 16px;
            color: #000;
        }

        .register-container input[type="submit"] {
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

        .register-container input[type="submit"]:hover {
            background-color: #d62828;
        }

        .register-container p {
            text-align: center;
            margin-top: 20px;
        }

        .register-container a {
            color: #e63946;
            text-decoration: none;
        }

        .register-container a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<header>
    <img src="image/logo.png" alt="FitZone Logo" class="logo">
    <ul class="nav-links">
        <li><a href="../index.php">Home</a></li>
        <li><a href="about.php">About</a></li>
        <li><a class="active" href="register.php">Register</a></li>
      
        <li><a href="membership.php">Membership</a></li>
        <li><a href="contact.php">Contact</a></li>
    </ul>
</header>

<div class="register-container">
    <h3>Sign Up</h3>
    <form name="myform" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="username">Username:</label>
        <input type="text" name="username" id="username" required>

        <label for="emailid">Email:</label>
        <input type="email" name="emailid" id="emailid" required>

        <label for="pwsd">Password:</label>
        <input type="password" name="pwsd" id="pwsd" required>

        <input type="submit" value="Sign Up" name="signup" id="submit">
    </form>

    <p>Already have an account? <a href="login.php">Login here</a></p>
    <p>Admin or Staff? <a href="admin_staff_login.php">Login here</a></p>
    <p><a href="../index.php">Back to Home</a></p>
</div>

<?php 
include('dbconnect.php');
error_reporting(E_ALL);

if (isset($_POST['signup'])) {
    $usern = trim($_POST['username']);
    $passw = trim($_POST['pwsd']);
    $email = trim($_POST['emailid']);
    $user_type = 'customer';

    $hashed_password = password_hash($passw, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("INSERT INTO users (username, pwd, email, role) VALUES (?, ?, ?, ?)");

    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("ssss", $usern, $hashed_password, $email, $user_type);
    
    if ($stmt->execute()) {
        echo '<script>alert("Registration successful. Now you can login."); window.location="login.php";</script>';
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}
$conn->close();
?>

</body>
</html>
