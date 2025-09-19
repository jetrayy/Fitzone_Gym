<?php
session_start();
include('dbconnect.php');
error_reporting(0);

// Check if the user is logged in
$isLoggedIn = isset($_SESSION['username']);
$isLoggedId = isset($_SESSION['user_id']);

// Check if the user is trying to update an appointment
if (isset($_GET['update_id'])) {
    $update_id = $_GET['update_id'];

    // Fetch the appointment details
    $sql = "SELECT appointments.id, trainers.trainer_id, trainers.name AS trainer_name, appointments.appointment_date, appointments.appointment_time 
            FROM appointments 
            JOIN trainers ON appointments.trainer_id = trainers.trainer_id  
            WHERE id = '$update_id' AND user_id = '".$_SESSION['user_id']."'";
    $result = $conn->query($sql);
    $appointment = $result->fetch_assoc();

    if ($appointment) {
        // If the appointment exists, display the update form
        if (isset($_POST['update'])) {
            // Retrieve the selected trainer_id, date, and time from the form
            $trainer_id = $_POST['trainer_id']; // Correctly fetch the trainer_id
            $appointment_date = $_POST['appointment_date'];
            $appointment_time = $_POST['appointment_time'];

            // Update the appointment in the database with the new trainer and appointment details
            $update_sql = "UPDATE appointments 
                          SET appointment_date = '$appointment_date', 
                              appointment_time = '$appointment_time', 
                              trainer_id = '$trainer_id' 
                          WHERE id = '$update_id' AND user_id = '".$_SESSION['user_id']."'";

            if ($conn->query($update_sql) === TRUE) {
                echo "<script>alert('Appointment updated successfully!'); window.location.href = 'viewappointment.php';</script>";
            } else {
                echo "<script>alert('Error updating appointment: " . $conn->error . "');</script>";
            }
        }
    } else {
        echo "<script>alert('Appointment not found or you do not have permission to edit it.'); window.location.href = 'your_file_name.php';</script>";
    }
} else {
    echo "<script>alert('No appointment selected for update.'); window.location.href = 'your_file_name.php';</script>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Appointment</title>
</head>
<body>
    <h1>Update Appointment</h1>
    <form action="" method="POST">
        <label for="trainer">Trainer</label>
        <select id="trainer" name="trainer_id" required>
            <option value="">-- Choose Trainer --</option>
            <?php
                // Fetch the list of trainers from the database
                $query = "SELECT trainer_id, name FROM trainers";
                $result = $conn->query($query);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        // Check if the trainer_id matches the current appointment's trainer_id
                        $selected = ($row['trainer_id'] == $appointment['trainer_id']) ? 'selected' : '';
                        echo "<option value='" . $row['trainer_id'] . "' $selected>" . htmlspecialchars($row['name']) . "</option>";
                    }
                } else {
                    echo "<option value=''>No trainers available</option>";
                }
            ?>
        </select><br>

        <label for="appointment_date">Date:</label>
        <input type="date" id="appointment_date" name="appointment_date" value="<?php echo $appointment['appointment_date']; ?>" required><br>

        <label for="appointment_time">Time:</label>
        <input type="time" id="appointment_time" name="appointment_time" value="<?php echo $appointment['appointment_time']; ?>" required><br>

        <button type="submit" name="update">Update Appointment</button>
    </form>
    <a href="viewappointment.php">View My Sessions</a>
</body>
</html>

<?php
$conn->close();
?>
