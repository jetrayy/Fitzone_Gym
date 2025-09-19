<?php
session_start();
include('../dbconnect.php');  // Include the database connection file

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");  // Redirect to login if not logged in
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the data from the form
    $subject = mysqli_real_escape_string($conn, $_POST['subject']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);
    $user_id = $_SESSION['user_id'];  // Get the logged-in user ID

    // Insert the query into the database
    $query = "INSERT INTO queries (user_id, subject, message, status) VALUES ('$user_id', '$subject', '$message', 'unread')";
    if (mysqli_query($conn, $query)) {
        $success_message = "Your query has been submitted successfully!";
    } else {
        $error_message = "There was an error submitting your query. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit Query - FitZone</title>
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
            background-color: #000;
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
            max-width: 800px;
            margin: 40px auto;
            background-color: rgba(0, 0, 0, 0.8);
            border-radius: 10px;
        }

        .form-section {
            margin-bottom: 30px;
        }

        .form-section input, .form-section textarea {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #444;
            border-radius: 5px;
            background-color: #222;
            color: white;
        }

        .form-section button {
            width: 100%;
            padding: 12px;
            background-color: red;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .form-section button:hover {
            background-color: darkred;
        }

        .error-msg, .success-msg {
            text-align: center;
            color: #ff4d4d;
        }

        .success-msg {
            color: #4CAF50;
        }
    </style>
</head>
<body>

<header>
    <div class="logo">
        <img src="../image/logo.png" alt="FitZone Logo">
    </div>
    <h1>Submit Query</h1>
    <div class="nav-links">
        <a href="user_dashboard.php">Go Back</a>
    </div>
</header>

<div class="container">
    <div class="form-section">
        <h2>Submit Your Query</h2>
        <form action="" method="POST">
            <label for="subject">Subject:</label>
            <input type="text" name="subject" id="subject" required>

            <label for="message">Message:</label>
            <textarea name="message" id="message" rows="6" required></textarea>

            <button type="submit">Submit Query</button>
        </form>
    </div>

    <?php if (isset($success_message)) { ?>
        <p class="success-msg"><?php echo $success_message; ?></p>
    <?php } ?>

    <?php if (isset($error_message)) { ?>
        <p class="error-msg"><?php echo $error_message; ?></p>
    <?php } ?>
</div>

</body>
</html>
