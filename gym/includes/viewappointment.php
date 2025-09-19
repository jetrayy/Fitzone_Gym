<?php
session_start();
include('dbconnect.php');
error_reporting(0);

// Check if the user is logged in
$isLoggedIn = isset($_SESSION['username']);
$isLoggedId = isset($_SESSION['user_id']);

// Handle the delete action
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];

    // Prepare and execute the DELETE query
    $sql = "DELETE FROM appointments WHERE id = '$delete_id' AND user_id = '".$_SESSION['user_id']."'";
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Appointment deleted successfully!'); window.location.href = 'your_file_name.php';</script>";
    } else {
        echo "<script>alert('Error deleting appointment: " . $conn->error . "');</script>";
    }
}

if ($isLoggedIn): ?>

    <h1>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
    <h2>Your Appointments</h2>

    <?php
    // Fetch appointments for the logged-in user
    $sql = "SELECT appointments.id,  trainers.name AS trainer_name, appointments.appointment_date, appointments.appointment_time,appointments.session_type , appointments.status 
            FROM appointments 
            JOIN trainers ON appointments.trainer_id = trainers.trainer_id 
            WHERE appointments.user_id = '".$_SESSION['user_id']."'";

    $result = $conn->query($sql);

    if ($result->num_rows > 0): ?>
        <table border="1">
            <thead>
                <tr>
                    <th>Appointment ID</th>
                    <th>Trainer</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Session</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['trainer_name']; ?></td>
                        <td><?php echo $row['appointment_date']; ?></td>
                        <td><?php echo $row['appointment_time']; ?></td>
                        <td><?php echo $row['session_type']; ?></td>
                        <td><?php echo ucfirst($row['status']); ?></td>
                        <td>
                            <!-- Delete Link -->
                            <a href="?delete_id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this appointment?');">Delete</a> |
                            <!-- Update Link -->
                            <a href="update_appointment.php?update_id=<?php echo $row['id']; ?>">Update</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>You have no appointments scheduled.</p>
    <?php endif; ?>

<?php else: ?>
    <h2>Please log in to view your appointments.</h2>
<?php endif; ?>
<a href="../index.php">back to home</a>
<?php
$conn->close();
?>
