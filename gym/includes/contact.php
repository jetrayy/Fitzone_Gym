<?php
session_start();

// Include the dbconnect.php file with correct path
include('dbconnect.php'); // Adjust the path if necessary

// Handle contact form submission
if (isset($_POST['submit_contact'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);
    
    // Insert contact form data into the database
    $query = "INSERT INTO contact_messages (name, email, message) VALUES ('$name', '$email', '$message')";
    if (mysqli_query($conn, $query)) {
        $success_message = "Your message has been sent successfully!";
        echo "<script>alert('Message sent successfully!');</script>";
    } else {
        $error_message = "There was an error sending your message. Please try again.";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - FitZone</title>
    <link rel="icon" type="image/x-icon" href="image/icons/sicon.ico">
    <link rel="stylesheet" href="../styles/contact.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
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
            color: #fff;
            text-decoration: none;
            font-weight: bold;
            transition: color 0.3s;
        }

        .nav-links li a:hover,
        .nav-links li a.active {
            color: #e63946;
        }

        .contact-form {
            width: 100%;
            max-width: 600px;
            margin: 100px auto;
            padding: 30px;
            background: rgba(0, 0, 0, 0.8);
            border-radius: 10px;
            color: white;
            box-shadow: 0px 4px 8px rgba(255, 255, 255, 0.5);
        }

        .contact-form h2 {
            text-align: center;
            color: #e63946;
            margin-bottom: 25px;
        }

        .contact-form label {
            display: block;
            margin: 10px 0 5px;
            font-weight: bold;
        }

        .contact-form input, 
        .contact-form textarea {
            width: 100%;
            padding: 12px;
            border-radius: 8px;
            border: none;
            font-size: 16px;
            margin-bottom: 15px;
        }

        .contact-form textarea {
            resize: vertical;
            min-height: 120px;
        }

        .contact-form button {
            width: 100%;
            padding: 12px;
            background-color: #e63946;
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .contact-form button:hover {
            background-color: #d62828;
        }

        .success-message {
            text-align: center;
            margin-top: 20px;
            color: green;
            font-size: 1.2rem;
        }

        .error-message {
            text-align: center;
            margin-top: 20px;
            color: red;
            font-size: 1.2rem;
        }

        footer {
            background-color: #222;
            color: #fff;
            padding: 40px 20px;
            text-align: left;
        }

        .footer-section {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 20px;
        }

        .footer-section div {
            flex: 1;
            min-width: 250px;
        }

        .footer-section h2 {
            font-size: 1.5rem;
            margin-bottom: 10px;
        }

        .footer-section p {
            margin-bottom: 10px;
        }

        .social-icons a {
            color: #fff;
            margin-right: 10px;
            font-size: 1.5rem;
            transition: color 0.3s;
        }

        .social-icons a:hover {
            color: red;
        }

        .copyright {
            text-align: center;
            margin-top: 20px;
            border-top: 1px solid #444;
            padding-top: 20px;
        }
    </style>
</head>
<body>

<header>
    <img src="image/logo.png" alt="FitZone Logo" class="logo">
    <ul class="nav-links">
        <li><a href="../index.php">Home</a></li>
        <li><a href="about.php">About</a></li>
        <li><a href="register.php">Register</a></li>
        <li><a href="membership.php">Membership</a></li>
        <li><a class="active" href="contact.php">Contact</a></li>
    </ul>
</header>

<div class="contact-form">
    <h2>Contact Us</h2>
    <!-- Display Success or Error Message -->
    <?php if (isset($success_message)) { echo "<p class='success-message'>$success_message</p>"; } ?>
    <?php if (isset($error_message)) { echo "<p class='error-message'>$error_message</p>"; } ?>

    <form action="" method="POST">
        <label for="name">Your Name:</label>
        <input type="text" name="name" id="name" required>

        <label for="email">Your Email:</label>
        <input type="email" name="email" id="email" required>

        <label for="message">Your Message:</label>
        <textarea name="message" id="message" required></textarea>

        <button type="submit" name="submit_contact">Submit</button>
    </form>
</div>

<!-- Footer Section -->
<footer>
    <div class="footer-section">
        <!-- Newsletter -->
        <div>
            <h2>Subscribe to our Newsletter</h2>
            <p>Get the latest updates and fitness tips.</p>
            <form action="#" method="POST">
                <input type="email" name="newsletter_email" placeholder="Enter your email" required>
                <button type="submit">Subscribe</button>
            </form>
        </div>

        <!-- Contact Info -->
        <div>
            <h2>Contact Us</h2>
            <p><strong>Email:</strong> info@fitzone.com</p>
            <p><strong>Phone:</strong> +94 77 133 4557</p>
            <p><strong>Address:</strong> Main Street, Kurunagala, Sri Lanka</p>
        </div>

        <!-- Social Media -->
        <div>
            <h2>Follow Us</h2>
            <p>Stay connected:</p>
            <div class="social-icons">
                <a href="#"><i class="fab fa-facebook-f"></i></a>
                <a href="#"><i class="fab fa-instagram"></i></a>
                <a href="#"><i class="fab fa-twitter"></i></a>
                <a href="#"><i class="fab fa-youtube"></i></a>
            </div>
        </div>
    </div>

    <div class="copyright">
        <hr style="border-color: #444;">
        <p>&copy; <?php echo date("Y"); ?> FitZone Fitness Club. All rights reserved.</p>
    </div>
</footer>

</body>
</html>
