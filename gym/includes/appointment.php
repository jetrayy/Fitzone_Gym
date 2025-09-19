<?php
session_start();
include('dbconnect.php');

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");  // Redirect to login if not logged in
    exit();
}

// Get the logged-in user's ID
$user_id = $_SESSION['user_id'];

// Fetch current appointments for the user
$appointments_query = mysqli_query($conn, "SELECT * FROM appointments WHERE user_id = $user_id");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book a Training Session - FitZone</title>
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

        .form-section input, .form-section select, .form-section button {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border-radius: 5px;
            background-color: #222;
            color: white;
            border: 1px solid #444;
        }

        .form-section button {
            background-color: red;
            border: none;
        }

        .appointments-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 30px;
        }

        th, td {
            padding: 12px;
            text-align: center;
            border: 1px solid #444;
        }

        th {
            background-color: red;
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

        .view-appointments-btn {
            background-color: green;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 20px;
        }

        .view-appointments-btn:hover {
            background-color: darkgreen;
        }
    </style>
</head>
<body>

<header>
    <div class="logo">
        <img src="../image/logo.png" alt="FitZone Logo">
    </div>
    <h1>Book a Training Session</h1>
    <div class="nav-links">
        <a href="user/user_dashboard.php">Go Back</a>
        <a href="logout.php">Logout</a>
    </div>
</header>

<div class="container">
    <!-- Appointment Booking Form -->
    <div class="form-section">
        <h2>Book a Training Session</h2>
        <form action="" method="POST">
            <label for="trainer">Select Trainer:</label>
            <select id="trainer" name="trainer_id" required>
                <option value="">-- Choose Trainer --</option>
                <?php
                // Fetch trainers from the database
                $trainers_query = mysqli_query($conn, "SELECT trainer_id, name FROM trainers");
                while ($trainer = mysqli_fetch_assoc($trainers_query)) {
                    echo "<option value='{$trainer['trainer_id']}'>{$trainer['name']}</option>";
                }
                ?>
            </select>

            <label for="session_type">Training Session Type:</label>
            <select id="session_type" name="session_type" required>
                <option value="">-- Choose Session Type --</option>
                <option value="Weight Training">Weight Training</option>
                <option value="Cardio">Cardio</option>
                <option value="Yoga">Yoga</option>
                <option value="Zumba">Zumba</option>
            </select>

            <label for="session_date">Session Date:</label>
            <input type="date" id="session_date" name="session_date" required>

            <label for="session_time">Session Time:</label>
            <input type="time" id="session_time" name="session_time" required>

            <button type="submit" name="book_session">Book Session</button>
        </form>
    </div>

   

    <!-- User Appointments Table -->
    <h2>Your Appointments</h2>
    <table class="appointments-table">
        <tr>
            <th>Appointment ID</th>
            <th>Trainer</th>
            <th>Session Type</th>
            <th>Date</th>
            <th>Time</th>
            <th>Status</th>
        </tr>
        <?php while ($appointment = mysqli_fetch_assoc($appointments_query)): ?>
        <tr>
            <td><?= $appointment['id']; ?></td>
            <td><?= $appointment['trainer_id']; ?></td>
            <td><?= $appointment['session_type']; ?></td>
            <td><?= $appointment['appointment_date']; ?></td>
            <td><?= $appointment['appointment_time']; ?></td>
            <td><?= $appointment['status']; ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
</div>

<?php
// Handle session booking
if (isset($_POST['book_session'])) {
    // Get form values
    $trainer_id = $_POST['trainer_id'];
    $session_type = $_POST['session_type'];
    $session_date = $_POST['session_date'];
    $session_time = $_POST['session_time'];
    $status = 'pending'; // Default status

    // Insert session booking into the database
    $sql = "INSERT INTO appointments (user_id, trainer_id, session_type, appointment_date, appointment_time, status)
            VALUES ('$user_id', '$trainer_id', '$session_type', '$session_date', '$session_time', '$status')";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Session booked successfully!');</script>";
    } else {
        echo "<script>alert('Error: " . $conn->error . "');</script>";
    }
}
?>

</body>
</html>
